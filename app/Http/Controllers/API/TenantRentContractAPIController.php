<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Posts\FilterByTenantCriteria;
use App\Criteria\TenantsRentContract\FilterByBuildingCriteria;
use App\Criteria\TenantsRentContract\FilterByUnitCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Post\ShowRequest;
use App\Http\Requests\API\TenantRentContract\DeleteRequest;
use App\Http\Requests\API\TenantRentContract\UpdateRequest;
use App\Http\Requests\API\TenantRentContract\CreateRequest;
use App\Http\Requests\API\TenantRentContract\ListRequest;
use App\Models\TenantRentContract;
use App\Repositories\PostRepository;
use App\Repositories\TenantRentContractRepository;
use App\Transformers\TenantRentContractTransformer;
use App\Transformers\TenantTransformer;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class TenantRentContractController
 * @package App\Http\Controllers\API
 */
class TenantRentContractAPIController extends AppBaseController
{
    /** @var  TenantRentContractRepository */
    private $tenantRentContractRepository;

    /**
     * TenantRentContractAPIController constructor.
     * @param TenantRentContractRepository $tenantRentContractRepo
     */
    public function __construct(TenantRentContractRepository $tenantRentContractRepo)
    {
        $this->tenantRentContractRepository = $tenantRentContractRepo;
    }

    /**
     * @param ListRequest $request
     * @return Response
     * @throws \Exception
     *
     * @SWG\Get(
     *      path="/rent-contracts",
     *      summary="Get a listing of the TenantRentContracts.",
     *      tags={"TenantRentContract"},
     *      description="Get all TenantRentContracts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="building_id",
     *          in="query",
     *          type="integer",
     *          description="fuilter by building",
     *          required=false,
     *      ),
     *     @SWG\Parameter(
     *          name="tenant_id",
     *          type="integer",
     *          in="query",
     *          description="fuilter by tenant",
     *          required=false,
     *      ),
     *     @SWG\Parameter(
     *          name="unit_id",
     *          type="integer",
     *          in="query",
     *          description="fuilter by unit",
     *          required=false,
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/TenantRentContract")
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
        $request->merge([
            'model' => (new TenantRentContract)->table,
        ]);

        $this->tenantRentContractRepository->pushCriteria(new RequestCriteria($request));
        $this->tenantRentContractRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->tenantRentContractRepository->pushCriteria(new FilterByBuildingCriteria($request));
        $this->tenantRentContractRepository->pushCriteria(new FilterByUnitCriteria($request));
        $this->tenantRentContractRepository->pushCriteria(new FilterByTenantCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $request->merge(['limit' => env('APP_PAGINATE', 10)]);
            $this->tenantRentContractRepository->pushCriteria(new LimitOffsetCriteria($request));
            $tenantRentContracts = $this->tenantRentContractRepository->get();
            $response = (new TenantRentContractTransformer())->transformCollection($tenantRentContracts);
            return $this->sendResponse($response, 'TenantRentContracts retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        // @TODO TENANT_RENT_CONTRACT is need? building, address, unit . I think not need because many
        $tenantRentContracts = $this->tenantRentContractRepository->with(['tenant', 'building.address', 'unit'])->paginate($perPage);
        $response = (new TenantRentContractTransformer())->transformPaginator($tenantRentContracts);
        return $this->sendResponse($response, 'TenantRentContracts retrieved successfully');
    }


    /**
     * @param $id
     * @param ShowRequest $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @SWG\Get(
     *      path="/rent-contracts/{id}",
     *      summary="Display the specified Tenant Rent Contract",
     *      tags={"TenantRentContract"},
     *      description="Get Tenant Rent Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant Rent Contract",
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
     *                  ref="#/definitions/TenantRentContract"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id, ShowRequest $request)
    {
        /** @var TenantRentContract $tenant */
        $tenantRentContract = $this->tenantRentContractRepository->findWithoutFail($id);
        if (empty($tenantRentContract)) {
            return $this->sendError(__('models.tenant_rent_contract.errors.not_found'));
        }

        $tenantRentContract->load(['tenant', 'building.address', 'unit']);
        $response = (new TenantRentContractTransformer())->transform($tenantRentContract);
        return $this->sendResponse($response, 'Tenant Rent Contract retrieved successfully');
    }

    /**
     * @param CreateRequest $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Post(
     *      path="/rent-contracts",
     *      summary="Store a newly created Tenant renat Contract in storage",
     *      tags={"TenantRentContract"},
     *      description="Store Tenant Rent Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TenantRentContract")
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
     *                  ref="#/definitions/TenantRentContract"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        try {
            $tenantRentContract = $this->tenantRentContractRepository->create($input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant_rent_contract.errors.create') . $e->getMessage());
        }


        $tenantRentContract->load(['tenant', 'building.address', 'unit']);

        $response = (new TenantRentContractTransformer())->transform($tenantRentContract);
        return $this->sendResponse($response, __('models.tenant_rent_contract.saved'));
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @SWG\Put(
     *      path="/rent-contracts/{id}",
     *      summary="Update the specified Tenant Rent Contract in storage",
     *      tags={"TenantRentContract"},
     *      description="Update Tenant Rent Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant Rent Contract",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TenantRentContract")
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
     *                  ref="#/definitions/TenantRentContract"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     */
    public function update($id, UpdateRequest $request)
    {
        $input =  $input = $request->all();
        /** @var TenantRentContract $tenantRentContract */
        $tenantRentContract = $this->tenantRentContractRepository->findWithoutFail($id);
        if (empty($tenantRentContract)) {
            return $this->sendError(__('models.tenant_rent_contract.errors.not_found'));
        }

        try {
            $tenant = $this->tenantRentContractRepository->updateExisting($tenantRentContract, $input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.create') . $e->getMessage());
        }

        $tenantRentContract->load(['tenant', 'building.address', 'unit']);
        $response = (new TenantRentContractTransformer())->transform($tenantRentContract);
        return $this->sendResponse($response, __('models.tenant.saved'));
    }

    /**
     * @param int $id
     * @param DeleteRequest $request
     * @return Response
     *
     * @SWG\Delete(
     *      path="/rent-contracts/{id}",
     *      summary="Remove the specified Tenant Rent Contract from storage",
     *      tags={"TenantRentContract"},
     *      description="Delete TenantRentContract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TenantRentContract",
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
    public function destroy($id, DeleteRequest $request)
    {
        try {
            $this->tenantRentContractRepository->delete($id);
        } catch (\Exception $e) {
            return $this->sendError('Delete error: ' . $e->getMessage());
        }

        return $this->sendResponse($id, __('models.tenant_rent_contract.deleted'));
    }

    /**
     * @param DeleteRequest $request
     * @return mixed
     *
     *
     * @SWG\Post(
     *      path="/rent-contracts/deletewithids",
     *      summary="Remove multiple Tenant Rent Contract from storage",
     *      tags={"TenantRentContract"},
     *      description="Delete multiple TenantRentContract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="ids",
     *          description="id of TenantRentContract",
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
    public function destroyWithIds(DeleteRequest $request){
        $ids = $request->get('ids');
        try{
            TenantRentContract::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.tenant_rent_contract.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.tenant_rent_contract.deleted'));
    }
}
