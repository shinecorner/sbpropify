<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Units\FilterByRelatedFieldsCriteria;
use App\Criteria\Units\FilterByTypeCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Unit\CreateRequest;
use App\Http\Requests\API\Unit\DeleteRequest;
use App\Http\Requests\API\Unit\ListRequest;
use App\Http\Requests\API\Unit\UpdateRequest;
use App\Http\Requests\API\Unit\ViewRequest;
use App\Models\Unit;
use App\Repositories\PostRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UnitRepository;
use App\Transformers\UnitTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class UnitController
 * @package App\Http\Controllers\API
 */
class UnitAPIController extends AppBaseController
{
    /** @var  UnitRepository */
    private $unitRepository;

    /** @var  TenantRepository */
    private $tenantRepository;

    public function __construct(UnitRepository $unitRepo, TenantRepository $tenantRepo)
    {
        $this->unitRepository = $unitRepo;
        $this->tenantRepository = $tenantRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws /Exception
     *
     * @SWG\Get(
     *      path="/units",
     *      summary="Get a listing of the Units.",
     *      tags={"Unit"},
     *      description="Get all Units",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Unit")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(ListRequest $request)
    {
        $this->unitRepository->pushCriteria(new RequestCriteria($request));
        $this->unitRepository->pushCriteria(new FilterByRelatedFieldsCriteria($request));
        $this->unitRepository->pushCriteria(new FilterByTypeCriteria($request));
        $this->unitRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $units = $this->unitRepository->get();
            return $this->sendResponse($units->toArray(), 'Units retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $units = $this->unitRepository->with([
            'building', 'tenant.user', 'tenants.user'
        ])->paginate($perPage);

        $response = (new UnitTransformer)->transformPaginator($units);
        return $this->sendResponse($response, 'Units retrieved successfully');
    }

    /**
     * @param CreateRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/units",
     *      summary="Store a newly created Unit in storage",
     *      tags={"Unit"},
     *      description="Store Unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Unit that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Unit")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Unit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRequest $request, PostRepository $pr)
    {
        $input = $request->all();
        $input['sq_meter'] = $input['sq_meter'] ?? 0;
        try {
            $unit = $this->unitRepository->create($input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.unit.errors.create') . $e->getMessage());
        }

        if (isset($input['tenant_id'])) {
            try {
                $attr = [
                    'unit_id' => $unit->id,
                ];
                $tenant = $this->tenantRepository->update($attr, $input['tenant_id']);
                $pr->newTenantPost($tenant);
            } catch (\Exception $e) {
                return $this->sendError(__('models.unit.errors.tenant_assign') . $e->getMessage());
            }
        }

        $unit->load('tenant');
        $response = (new UnitTransformer)->transform($unit);
        return $this->sendResponse($response, __('models.unit.saved'));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/units/{id}",
     *      summary="Display the specified Unit",
     *      tags={"Unit"},
     *      description="Get Unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Unit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Unit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id, ViewRequest $r)
    {
        /** @var Unit $unit */
        $unit = $this->unitRepository->findWithoutFail($id);
        if (empty($unit)) {
            return $this->sendError(__('models.unit.errors.not_found'));
        }

        $unit->load('tenant');
        $response = (new UnitTransformer)->transform($unit);
        return $this->sendResponse($response, 'Unit retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/units/{id}",
     *      summary="Update the specified Unit in storage",
     *      tags={"Unit"},
     *      description="Update Unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Unit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Unit that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Unit")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Unit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRequest $request, PostRepository $pr)
    {
        $input = $request->all();

        /** @var Unit $unit */
        $unit = $this->unitRepository->findWithoutFail($id);
        if (empty($unit)) {
            return $this->sendError(__('models.unit.errors.not_found'));
        }
        $shouldPost = isset($input['tenant_id']) &&
            (!$unit->tenant || ($unit->tenant && $unit->tenant->id != $input['tenant_id']));

        try {
            $unit = $this->unitRepository->update($input, $id);
        } catch (\Exception $e) {
            return $this->sendError(__('models.unit.errors.update') . $e->getMessage());
        }

        $currentTenant = $unit->tenan ? $unit->tenant->id : 0;
        if (isset($input['tenant_id']) && $input['tenant_id'] != $currentTenant) {
            try {
                $this->tenantRepository->moveTenantInUnit($input['tenant_id'], $unit);
            } catch (\Exception $e) {
                return $this->sendError(__('models.unit.errors.create') . $e->getMessage());
            }
        }

        $unit->load('tenant');
        if ($shouldPost) {
            $pr->newTenantPost($unit->tenant);
        }

        $response = (new UnitTransformer)->transform($unit);
        return $this->sendResponse($response, __('models.unit.saved'));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/units/{id}",
     *      summary="Remove the specified Unit from storage",
     *      tags={"Unit"},
     *      description="Delete Unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Unit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id, DeleteRequest $r)
    {
        /** @var Unit $unit */
        $unit = $this->unitRepository->findWithoutFail($id);

        if (empty($unit)) {
            return $this->sendError(__('models.unit.errors.not_found'));
        }

        // TODO: unassign Tenant from deleted Unit
        $unit->delete();

        return $this->sendResponse($id, __('models.unit.deleted'));
    }
    public function destroyWithIds(Request $request){
        $ids = $request->get('ids');
        try{
            Unit::destroy($ids);      
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.unit.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.unit.deleted'));
    }
    /**
     * @SWG\Post(
     *      path="/units/{id}/assignees/{assignee_id}",
     *      summary="Assign the tenant to unit",
     *      tags={"Unit", "Tenant"},
     *      description="Assign the tenant to unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="unit id",
     *          type="integer",
     *      ),
     *      @SWG\Parameter(
     *          name="assignee_id",
     *          in="path",
     *          required=true,
     *          description="tenant id",
     *          type="integer",
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="not found",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Incorrect tenant"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="integer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="tenant assigned unit successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @param $unitId
     * @param $tenantId
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function assignTenant($unitId, $tenantId)
    {
        $unit = $this->unitRepository->find($unitId, ['id']);
        if (empty($unit)) {
            return $this->sendError(__('models.unit.errors.not_found'));
        }

        $tenant = $this->tenantRepository->find($tenantId, ['id']);
        if (empty($tenant)) {
            return $this->sendError(__('models.unit.errors.not_found'));
        }

        $data = [
            'unit_id' => $unit->id,
        ];
        $this->tenantRepository->update($data, $tenantId);
        return $this->sendResponse($unitId, __('models.unit.tenant_assigned'));
    }

    /**
     * @SWG\Delete(
     *      path="/units/{id}/assignees/{assignee_id}",
     *      summary="Un assign the tenant to unit",
     *      tags={"Unit", "Tenant"},
     *      description="Un assign the tenant to unit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="unit id",
     *          type="integer",
     *      ),
     *      @SWG\Parameter(
     *          name="assignee_id",
     *          in="path",
     *          required=true,
     *          description="tenant id",
     *          type="integer",
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="not found",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="false"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Incorrect tenant"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="integer"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="tenant un assigned unit successfully"
     *              )
     *          )
     *      )
     * )
     *
     * @param $unitId
     * @param $tenantId
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function unassignTenant($unitId, $tenantId)
    {
        $tenant = $this->tenantRepository->find($tenantId, ['id', 'unit_id']);
        if (empty($tenant)) {
            return $this->sendError(__('models.unit.errors.tenant_not_found'));
        }

        if ($tenant->unit_id !=  $unitId) {
            return $this->sendError(__('models.unit.errors.tenant_not_assign'));
        }

        $data = [
            'unit_id' => null,
            'building_id' => null,
            'address_id' => null,
        ];
        $this->tenantRepository->update($data, $tenantId);

        return $this->sendResponse($unitId, __('models.unit.tenant_unassigned'));
    }
}
