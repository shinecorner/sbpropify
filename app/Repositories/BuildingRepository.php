<?php

namespace App\Repositories;

use App\Models\Building;

/**
 * Class BuildingRepository
 * @package App\Repositories
 * @version January 27, 2019, 7:57 pm UTC
 *
 * @method Building findWithoutFail($id, $columns = ['*'])
 * @method Building find($id, $columns = ['*'])
 * @method Building first($columns = ['*'])
 */
class BuildingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
        'description' => 'like',
        'label' => 'like',
        'floor_nr' => 'like',
    ];

    protected $mimeToExtension = [
        "image/jpeg" =>  "jpg",
        "application/pdf" =>  "pdf",
        "image/png" =>  "png",
        "application/msword" =>  "doc",
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Building::class;
    }

    public function create(array $attributes)
    {
        if (isset($attributes['address'])) {
            unset($attributes['address']);
        }

        if (isset($attributes['quarter'])) {
            unset($attributes['quarter']);
        }

        // Have to skip presenter to get a model not some data
        $model = parent::create($attributes);

        if ($attributes['service_providers']) {
            $model->serviceProviders()->attach($attributes['service_providers']);
        }

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $model = parent::update($attributes, $id);

        if ($attributes['service_providers']) {
            $model->serviceProviders()->sync($attributes['service_providers']);
        }

        return $model;
    }

    public function delete($id)
    {
        $this->applyScope();

        $model = $this->find($id);

        $model->serviceProviders()->detach();

        $deleted = $model->delete();

        return $deleted;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $building
     * @param $floorData
     * @param $preText
     * @return mixed
     */
    public function saveManyUnit($building, $floorData, $preText)
    {
        if (! is_array($floorData)) {
            return $building;
        }

        $data = [];
        foreach ($floorData as $floor => $count) {
            if (! is_integer($count)) {
                continue;
            }
            for ($i = 1; $i <= $count; $i++) {
                $data[] = [
                    'floor' => $floor,
                    'unit_number' => $i,
                    'name' => $this->formatUnitName($preText, $floor, $i)
                ];
            }
        }
        $units = $building->units()->createMany($data);
        $building->setRelation('units', $units);
        return $building;
    }

    /**
     * @param $preText
     * @param $floor
     * @param $number
     * @return string
     */
    protected function formatUnitName($preText, $floor, $number)
    {
        if ($number < 10) {
            $number = '0' . $number;
        }
        return $preText . '-' . $floor . $number;
    }
}
