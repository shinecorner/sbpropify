<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Posts\FilterByTenantCriteria;
use App\Criteria\TenantsRentContract\FilterByBuildingCriteria;
use App\Criteria\TenantsRentContract\FilterByUnitCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Post\ShowRequest;
use App\Http\Requests\API\RentContract\DeleteRequest;
use App\Http\Requests\API\RentContract\UpdateRequest;
use App\Http\Requests\API\RentContract\CreateRequest;
use App\Http\Requests\API\RentContract\ListRequest;
use App\Models\RentContract;
use App\Repositories\RentContractRepository;
use App\Transformers\RentContractTransformer;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class RentContractController
 * @package App\Http\Controllers\API
 */
class RentContractAPIController extends AppBaseController
{
    /** @var  RentContractRepository */
    private $rentContractRepository;

    /**
     * RentContractAPIController constructor.
     * @param RentContractRepository $rentContractRepo
     */
    public function __construct(RentContractRepository $rentContractRepo)
    {
        $this->rentContractRepository = $rentContractRepo;
    }

    /**
     * @param ListRequest $request
     * @return Response
     * @throws \Exception
     *
     * @SWG\Get(
     *      path="/rent-contracts",
     *      summary="Get a listing of the RentContracts.",
     *      tags={"RentContract"},
     *      description="Get all RentContracts",
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
     *                  @SWG\Items(ref="#/definitions/RentContract")
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
            'model' => (new RentContract)->getTable(),
        ]);

        $this->rentContractRepository->pushCriteria(new RequestCriteria($request));
        $this->rentContractRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->rentContractRepository->pushCriteria(new FilterByBuildingCriteria($request));
        $this->rentContractRepository->pushCriteria(new FilterByUnitCriteria($request));
        $this->rentContractRepository->pushCriteria(new FilterByTenantCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $request->merge(['limit' => env('APP_PAGINATE', 10)]);
            $this->rentContractRepository->pushCriteria(new LimitOffsetCriteria($request));
            $rentContracts = $this->rentContractRepository->get();
            $response = (new RentContractTransformer())->transformCollection($rentContracts);
            return $this->sendResponse($response, 'RentContracts retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        // @TODO TENANT_RENT_CONTRACT is need? building, address, unit . I think not need because many
        $rentContracts = $this->rentContractRepository->with(['tenant', 'building.address', 'unit'])->paginate($perPage);
        $response = (new RentContractTransformer())->transformPaginator($rentContracts);
        return $this->sendResponse($response, 'RentContracts retrieved successfully');
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
     *      tags={"RentContract"},
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
     *                  ref="#/definitions/RentContract"
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
        /** @var RentContract $tenant */
        $rentContract = $this->rentContractRepository->findWithoutFail($id);
        if (empty($rentContract)) {
            return $this->sendError(__('models.tenant_rent_contract.errors.not_found'));
        }

        $rentContract->load(['tenant', 'building.address', 'unit']);
        $response = (new RentContractTransformer())->transform($rentContract);
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
     *      tags={"RentContract"},
     *      description="Store Tenant Rent Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RentContract")
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
     *                  ref="#/definitions/RentContract"
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
            $rentContract = $this->rentContractRepository->create($input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant_rent_contract.errors.create') . $e->getMessage());
        }


        $rentContract->load(['tenant', 'building.address', 'unit']);

        $response = (new RentContractTransformer())->transform($rentContract);
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
     *      tags={"RentContract"},
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
     *          @SWG\Schema(ref="#/definitions/RentContract")
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
     *                  ref="#/definitions/RentContract"
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
        /** @var RentContract $rentContract */
        $rentContract = $this->rentContractRepository->findWithoutFail($id);
        if (empty($rentContract)) {
            return $this->sendError(__('models.tenant_rent_contract.errors.not_found'));
        }

        try {
            $tenant = $this->rentContractRepository->updateExisting($rentContract, $input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.create') . $e->getMessage());
        }

        $rentContract->load(['tenant', 'building.address', 'unit']);
        $response = (new RentContractTransformer())->transform($rentContract);
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
     *      tags={"RentContract"},
     *      description="Delete RentContract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RentContract",
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
            $this->rentContractRepository->delete($id);
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
     *      tags={"RentContract"},
     *      description="Delete multiple RentContract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="ids",
     *          description="id of RentContract",
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
            RentContract::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.tenant_rent_contract.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.tenant_rent_contract.deleted'));
    }
}
