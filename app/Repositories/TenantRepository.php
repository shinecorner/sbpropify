<?php

namespace App\Repositories;

use App\Models\Model;
use App\Models\RentContract;
use App\Models\ServiceRequest;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Support\Arr;
use Prettus\Repository\Events\RepositoryEntityDeleted;

/**
 * Class TenantRepository
 * @package App\Repositories
 * @version January 28, 2019, 8:27 pm UTC
 *
 * @method Tenant findWithoutFail($id, $columns = ['*'])
 * @method Tenant find($id, $columns = ['*'])
 * @method Tenant first($columns = ['*'])
 */
class TenantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name' => 'like',
        'last_name' => 'like',
        'birth_date' => 'like',
        'mobile_phone' => 'like',
        'private_phone' => 'like',
        'work_phone' => 'like',
        'user.email' => 'like',
    ];

    /**
     * @var array
     */
    protected $mimeToExtension = [
        "application/pdf" => "pdf",
        "image/png" => "png",
        "image/jpeg" => "jpg",
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tenant::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes)
    {
        if (isset($attributes['unit_id'])) {
            $unit = Unit::with('building')->find($attributes['unit_id']);
            if ($unit) {
                $attributes['building_id'] = $unit->building_id;
                $attributes['unit_id'] = $unit->id;
                $attributes['address_id'] = $unit->building->address_id;
            }
            unset($attributes['unit']);
        }

        if (isset($attributes['address'])) {
            unset($attributes['address']);
        }

        if (isset($attributes['building'])) {
            unset($attributes['building']);
        }

        if (isset($attributes['user'])) {
            unset($attributes['user']);
        }

        if (!isset($attributes['title']) || $attributes['title'] != 'company') {
            unset($attributes['company']);
        }

        $attributes['status'] = Tenant::StatusActive;
        $model = parent::create($attributes);
        if ($model) {
            $model = $this->saveRentContracts($model, $attributes);
        }
        return $model;
    }

    protected function saveRentContracts($model, $data)
    {
        if (empty($data['rent_contracts'])) {
            return $model;
        }

        $savedData = [];
        foreach ($data['rent_contracts'] as $rentContractData) {
            // @TODO if need validate this data
            if (is_array($rentContractData)) {
                $savedData[] = $rentContractData;
            }
        }
        if ($savedData) {
            $model->rent_contracts()->createMany($savedData);
        }
        return $model;
    }

    /**
     * @param int $building_id
     * @return mixed
     */
    public function getTotalTenantsFromBuilding(int $building_id)
    {
        return $this->model->where('building_id', $building_id)->count();
    }

    /**
     * @param int $tenant_id
     * @param Unit $unit
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function moveTenantInUnit(int $tenant_id, Unit $unit)
    {
        // Move old tenants outs of this unit
        $this->model->where('unit_id', $unit->id)->update(['unit_id' => null]);

        // Move in the new tenant
        $attrs = [
            'unit_id' => $unit->id,
            'building_id' => $unit->building_id,
            'address_id' => $unit->building->address_id,
        ];
        return $this->update($attrs, $tenant_id);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $model = $this->model->findOrFail($id);
        return $this->updateExisting($model, $attributes);
    }

    /**
     * @param Model $model
     * @param $attributes
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateExisting(Model $model, $attributes)
    {
        if (isset($attributes['unit_id'])) {
            $unit = Unit::with('building')->find($attributes['unit_id']);
            if ($unit) {
                $attributes['building_id'] = $unit->building_id;
                $attributes['unit_id'] = $unit->id;
                $attributes['address_id'] = $unit->building->address_id;
            }
            unset($attributes['unit']);
        }

        if (isset($attributes['address'])) {
            unset($attributes['address']);
        }

        if (isset($attributes['building'])) {
            unset($attributes['building']);
        }

        if (isset($attributes['user'])) {
            unset($attributes['user']);
        }

        if (!isset($attributes['title']) || $attributes['title'] != 'company') {
            unset($attributes['company']);
        }

        if ($attributes['status'] != $model->status && $attributes['status'] == Tenant::StatusNotActive) {
            $model->rent_contracts()
                ->where('status', RentContract::StatusActive)
                ->update(['status' =>  RentContract::StatusInactive]);
        }

        $model =  parent::updateExisting($model, $attributes); // TODO: Change the autogenerated stub
        return $model;
    }

    /**
     * @param $attributes
     * @param $currentStatus
     * @return bool
     */
    public function checkStatusPermission($attributes, $currentStatus)
    {
        if (!$attributes['status'] || $currentStatus == $attributes['status']) {
            return true;
        }

        return true;
    }

    /**
     * @param $id
     * @return bool|int|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->applyScope();
        $model = $this->find($id);
        $originalModel = clone $model;
        $this->resetModel();

        $requestsInProgress = $model->requests()
            ->whereIn('status', [
                ServiceRequest::StatusInProcessing,
                ServiceRequest::StatusAssigned,
                ServiceRequest::StatusReactivated,
            ])->get();

        if (count($requestsInProgress)) {
            throw new \Exception('Tenant has requests in progress');
        }

        $deleted = $model->forceDelete();

        event(new RepositoryEntityDeleted($this, $originalModel));

        return $deleted;
    }

    /**
     * @param $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null|void
     */
    public function findForCredentials($id, $columns = ['*'])
    {
         try {
             if (["*"] != $columns) {
                 $columns[] = 'user_id';
                 $columns = array_unique($columns);
             }

             return $this->model->with(['user' => function($q) {
                 $q->with('settings:user_id,language');
             }])->find($id, $columns);
         } catch (\Exception $e) {
             return;
         }
    }
}
