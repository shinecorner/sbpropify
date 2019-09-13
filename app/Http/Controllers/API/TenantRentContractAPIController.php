<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\FilterFullnameCriteria;
use App\Criteria\Common\RequestCriteria;
use App\Criteria\Posts\FilterByTenantCriteria;
use App\Criteria\TenantsRentContract\FilterByBuildingCriteria;
use App\Criteria\TenantsRentContract\FilterByUnitCriteria;
use App\Http\Controllers\AppBaseController;
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
     *      path="/tenant-rent-contracts",
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
     * @param CreateRequest $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Post(
     *      path="/tenants-rent-contracts",
     *      summary="Store a newly created Tenant renat contract in storage",
     *      tags={"TenantRentContract"},
     *      description="Store Tenant rent contract",
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


}
