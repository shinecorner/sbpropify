<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\FilterFullnameCriteria;
use App\Criteria\Common\RequestCriteria;
use App\Criteria\Common\WhereCriteria;
use App\Criteria\Tenants\FilterByBuildingCriteria;
use App\Criteria\Tenants\FilterByQuarterCriteria;
use App\Criteria\Tenants\FilterByRequestCriteria;
use App\Criteria\Tenants\FilterByStateCriteria;
use App\Criteria\Tenants\FilterByStatusCriteria;
use App\Criteria\Tenants\FilterByUnitCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Tenant\CreateRequest;
use App\Http\Requests\API\Tenant\DeleteRequest;
use App\Http\Requests\API\Tenant\DownloadCredentialsRequest;
use App\Http\Requests\API\Tenant\ListRequest;
use App\Http\Requests\API\Tenant\SendCredentialsRequest;
use App\Http\Requests\API\Tenant\ShowRequest;
use App\Http\Requests\API\Tenant\UpdateLoggedInRequest;
use App\Http\Requests\API\Tenant\UpdateRequest;
use App\Http\Requests\API\Tenant\UpdateStatusRequest;
use App\Models\RealEstate;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\TenantCredentials;
use App\Repositories\PostRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;
use App\Transformers\TenantTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Illuminate\Support\Facades\Validator;

/**
 * Class TenantController
 * @package App\Http\Controllers\API
 */
class TenantAPIController extends AppBaseController
{
    /** @var  TenantRepository */
    private $tenantRepository;

    /** @var  UserRepository */
    private $userRepository;

    /**
     * @var string
     */
    private $credentialsFileNotFound = "Credentials file not found. Try updating the tenant password to regenerate it";

    /**
     * TenantAPIController constructor.
     * @param TenantRepository $tenantRepo
     * @param UserRepository $userRepo
     */
    public function __construct(TenantRepository $tenantRepo, UserRepository $userRepo)
    {
        $this->tenantRepository = $tenantRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * @param ListRequest $request
     * @return Response
     * @throws \Exception
     *
     * @SWG\Get(
     *      path="/tenants",
     *      summary="Get a listing of the Tenants.",
     *      tags={"Tenant"},
     *      description="Get all Tenants",
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
     *                  @SWG\Items(ref="#/definitions/Tenant")
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
            'model' => (new Tenant)->table,
        ]);

        $this->tenantRepository->pushCriteria(new FilterByBuildingCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByQuarterCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByStateCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByRequestCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByUnitCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByStatusCriteria($request));
        $this->tenantRepository->pushCriteria(new RequestCriteria($request));
        $this->tenantRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterFullnameCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $request->merge(['limit' => env('APP_PAGINATE', 10)]);
            $this->tenantRepository->pushCriteria(new LimitOffsetCriteria($request));
            $tenants = $this->tenantRepository->get();
            $this->fixCreatedBy($tenants);
            return $this->sendResponse($tenants->toArray(), 'Tenants retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $tenants = $this->tenantRepository->with(['user', 'building.address', 'unit'])->paginate($perPage);
        $this->fixCreatedBy($tenants);
        return $this->sendResponse($tenants->toArray(), 'Tenants retrieved successfully');
    }

    /**
     * @param ListRequest $request
     * @return Response
     * @throws \Exception
     *
     * @SWG\Get(
     *      path="/tenants/latest",
     *      summary="Get a latest 5 Tenants",
     *      tags={"Tenant"},
     *      description="Get a latest 5(limit) Tenants",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="limit",
     *          in="query",
     *          description="How many tenants get",
     *          type="integer",
     *          default=5
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="true"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(
     *                      @SWG\Property(
     *                          property="id",
     *                          type="integer",
     *                      ),
     *                      @SWG\Property(
     *                          property="first_name",
     *                          type="string"
     *                      ),
     *                      @SWG\Property(
     *                          property="last_name",
     *                          type="string"
     *                      ),
     *                      @SWG\Property(
     *                          property="status",
     *                          type="integer"
     *                      )
     *                  )
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param ListRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function latest(ListRequest $request)
    {
        $limit = $request->get('limit', 5);
        $request->merge([
            'limit' => $limit,
        ]);
        $this->tenantRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->tenantRepository->pushCriteria(new RequestCriteria($request));
        $tenants = $this->tenantRepository->with('address:id,street,street_nr')->get(['id', 'address_id', 'first_name', 'last_name', 'status', 'created_at']);
        $this->fixCreatedBy($tenants);
        return $this->sendResponse($tenants->toArray(), 'Tenants retrieved successfully');
    }

    protected function fixCreatedBy($tenants)
    {
        foreach ($tenants as $tenant) {
            $tenant->created_by = $tenant->created_at->format('d.m.Y');
        }
    }

    /**
     * @param CreateRequest $request
     * @param PostRepository $pr
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     *
     * @SWG\Post(
     *      path="/tenants",
     *      summary="Store a newly created Tenant in storage",
     *      tags={"Tenant"},
     *      description="Store Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tenant")
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
     *                  ref="#/definitions/Tenant"
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
        $input = (new TenantTransformer)->transformRequest($request->all());
        //@TODO This action already done in  TenantTransformer delete it
        $input['user']['name'] = sprintf('%s %s', $input['first_name'], $input['last_name']);
        $validator = Validator::make($input['user'], User::$rules);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        try {
            $input['user']['role'] = 'registered';
            $input['user']['settings'] = Arr::pull($input, 'settings');
            $user = $this->userRepository->create($input['user']);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.create') . $e->getMessage());
        }

        $input['user_id'] = $user->id;
        try {
            $tenant = $this->tenantRepository->create($input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.create') . $e->getMessage());
        }

        $tenant->load('user', 'building', 'unit', 'address');
        $pr->newTenantPost($tenant);
        //$tenant->setCredentialsPDF();

        $response = (new TenantTransformer)->transform($tenant);
        return $this->sendResponse($response, __('models.tenant.saved'));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tenants/{id}",
     *      summary="Display the specified Tenant",
     *      tags={"Tenant"},
     *      description="Get Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant",
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
     *                  ref="#/definitions/Tenant"
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
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->findWithoutFail($id);
        $tenant->load('settings');
        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $tenant->load('user', 'building', 'unit', 'address', 'media');
        $response = (new TenantTransformer)->transform($tenant);

        return $this->sendResponse($response, 'Tenant retrieved successfully');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/tenants/me",
     *      summary="Display the Logged In Tenant",
     *      tags={"Tenant"},
     *      description="Get Logged In Tenant",
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
     *                  ref="#/definitions/Tenant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function showLoggedIn(Request $request)
    {
        /** @var User $user */
        $user = $this->userRepository->with('tenant')->findWithoutFail($request->user()->id);
        if (empty($user) || empty($user->tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $user->tenant->load('user', 'building', 'unit', 'address', 'media');
        $response = (new TenantTransformer)->transform($user->tenant);

        return $this->sendResponse($response, 'Tenant retrieved successfully');
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @param PostRepository $pr
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Put(
     *      path="/tenants/{id}",
     *      summary="Update the specified Tenant in storage",
     *      tags={"Tenant"},
     *      description="Update Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tenant")
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
     *                  ref="#/definitions/Tenant"
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
        $input = (new TenantTransformer)->transformRequest($request->all());
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->findWithoutFail($id);
        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $shouldPost = isset($input['unit_id']) && $input['unit_id'] != $tenant->unit_id;

        $input['user'] = $input['user'] ?? [];
        $input['user']['name'] = sprintf('%s %s', $input['first_name'], $input['last_name']);
        $input['user']['email'] = $input['email'];
        if (isset($input['password'])) {
            $input['user']['password'] = $input['password'];
        }

        $validator = Validator::make($input['user'], User::$rulesUpdate);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['user']['settings'] = Arr::pull($input, 'settings', []);
        try {
            // for prevent user update log related tenant
            User::disableAuditing();
            $updatedUser = $this->userRepository->update($input['user'], $tenant->user_id);
            $tenant->setRelation('user', $updatedUser);
            User::enableAuditing();
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.update') . $e->getMessage());
        }

        try {
            $tenant = $this->tenantRepository->updateExisting($tenant, $input);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.create') . $e->getMessage());
        }

        $tenant->load('building', 'unit', 'address', 'media', 'settings');
        if ($shouldPost) {
            $pr->newTenantPost($tenant);
        }
        //if ($userPass) {
            //$tenant->setCredentialsPDF();
        //}
        $response = (new TenantTransformer)->transform($tenant);
        return $this->sendResponse($response, __('models.tenant.saved'));
    }

    /**
     * @param UpdateLoggedInRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tenants/me",
     *      summary="Update the Logged In Tenant in storage",
     *      tags={"Tenant"},
     *      description="Update the Logged In Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tenant")
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
     *                  ref="#/definitions/Tenant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function updateLoggedIn(UpdateLoggedInRequest $request)
    {
        $input = $request->only((new Tenant)->getFillable());

        /** @var User $user */
        $user = $this->userRepository->with('tenant')->findWithoutFail($request->user()->id);
        if (empty($user)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $userInput = $request->get('user', []);
        $userInput['name'] = sprintf('%s %s', $input['first_name'], $input['last_name']);
        $userInput['email'] = $user->email;
        $validator = Validator::make($userInput, User::$rulesUpdate);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        try {
            $this->userRepository->update($userInput, $user->id);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.update') . $e->getMessage());
        }


        try {
            $tenant = $this->tenantRepository->update($input, $user->tenant->id);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.update') . $e->getMessage());
        }

        $tenant->load('user', 'address', 'building', 'unit', 'media');
        $response = (new TenantTransformer)->transform($tenant);
        return $this->sendResponse($response, __('models.tenant.saved'));
    }

    /**
     * @param int $id
     * @param UpdateStatusRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tenants/{id}/status",
     *      summary="Change status on Tenant",
     *      tags={"Tenant"},
     *      description="Change status on Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tenant that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tenant")
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
     *                  ref="#/definitions/Tenant"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function changeStatus(int $id, UpdateStatusRequest $request)
    {
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->with('user')->findWithoutFail($id);
        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $validator = Validator::make($request->all(), ['status' => 'required|integer|in:1,2']);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input = [
            'status' => $request->get('status', '')
        ];

        if (!$this->tenantRepository->checkStatusPermission($input, $tenant->status)) {
            return $this->sendError(__('models.tenant.errors.not_allowed_change_status'));
        }

        if ($input['status'] == Tenant::StatusNotActive) {
            $input['building_id'] = null;
            $input['unit_id'] = null;
            // $input['address_id'] = null;
        }

        try {
            $tenant = $this->tenantRepository->update($input, $id);
        } catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.update') . $e->getMessage());
        }

        $tenant->load('user', 'address', 'building', 'unit', 'media');
        $response = (new TenantTransformer)->transform($tenant);
        return $this->sendResponse($response, __('models.tenant.status_changed'));
    }

    /**
     * @param int $id
     * @param DeleteRequest $request
     * @return Response
     *
     * @SWG\Delete(
     *      path="/tenants/{id}",
     *      summary="Remove the specified Tenant from storage",
     *      tags={"Tenant"},
     *      description="Delete Tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tenant",
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
            $this->tenantRepository->delete($id);
        } catch (\Exception $e) {
            return $this->sendError('Delete error: ' . $e->getMessage());
        }

        return $this->sendResponse($id, __('models.tenant.deleted'));
    }
    public function destroyWithIds(Request $request){
        $ids = $request->get('ids');
        try{
            Tenant::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.tenant.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.tenant.deleted'));
    }
    /**
     * @param $id
     * @param DownloadCredentialsRequest $r
     * @return mixed
     */
    public function downloadCredentials($id, DownloadCredentialsRequest $r)
    {
        $t = $this->tenantRepository->findForCredentials($id);
        if (empty($t)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }
        $pdfName = $this->getPdfName($t);

        if (!\Storage::disk('tenant_credentials')->exists($pdfName)) {
            return $this->sendError($this->credentialsFileNotFound);
        }
        return \Storage::disk('tenant_credentials')->download($pdfName, $pdfName);
    }

    /**
     * @param $id
     * @param SendCredentialsRequest $r
     * @param TemplateRepository $tRepo
     * @return mixed
     */
    public function sendCredentials($id, SendCredentialsRequest $r, TemplateRepository $tRepo)
    {
        $t = $this->tenantRepository->findForCredentials($id);
        if (empty($t)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }
        $pdfName = $this->getPdfName($t);
        if (!\Storage::disk('tenant_credentials')->exists($pdfName)) {
            return $this->sendError($this->credentialsFileNotFound);
        }

        $t->user->notify(new TenantCredentials($t));

        return $this->sendResponse($id, __('models.tenant.credentials_sent'));
    }

    /**
     * @param $tenant
     * @return mixed
     */
    protected function getPdfName(Tenant $tenant)
    {
        $tenant->setCredentialsPDF();

        $re = RealEstate::firstOrFail();

        $pdfName = $tenant->pdfXFileName();
        if ($re && $re->blank_pdf) {
            $pdfName = $tenant->pdfFileName();
        }

        return $pdfName ;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function resetPassword(Request $request){

        $this->tenantRepository->pushCriteria(new WhereCriteria('activation_code', $request->token));
        $tenant = $this->tenantRepository->with('user:id,email')->first();

        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }

        $user = $tenant->user;
        if($user->email == $request->email) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->sendResponse($tenant->id, __('models.tenant.password_reset'));
        } else {
            return $this->sendError(__('models.tenant.errors.incorrect_email'));
        }
    }

    /**
     *
     * @SWG\Post(
     *      path="/tenants/activateTenant",
     *      summary="Activate tenant",
     *      tags={"Tenant"},
     *      description="Activate tenant",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="code",
     *          description="activation code of Tenant",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          description="email of Tenant",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          description="new password for Tenant can login",
     *          type="string",
     *          required=true,
     *          in="query"
     *      ),
     *
     *      @SWG\Response(
     *          response=401,
     *          description="wrong operation",
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
     *                  example="code, email, password required"
     *              )
     *          )
     *      ),
     *
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="true"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string",
     *                  example="2"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Tenant password reset successfully"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function activateTenant(Request $request)
    {
        // @TODO fix query hard coding
        if (empty($request->code) || empty($request->email) || empty($request->password)) {
            return $this->sendError(__('general.tenant_detail.activate_required_credentials'));
        }
        
        $this->userRepository->pushCriteria(new WhereCriteria('email', $request->email));
        $user = $this->userRepository->with('tenant:id,user_id,activation_code,status')->first();

        if (empty($user)) {
            return $this->sendError(__('general.tenant_detail.incorrect_email'));
        }

        if (empty($user->tenant)) {
            return $this->sendError(__('general.tenant_detail.user_not_tenant'));
        }

        if ($user->tenant->activation_code != $request->code) {

            return $this->sendError(__('general.tenant_detail.invalid_code'));
        }

        if (Tenant::StatusActive != $user->tenant->status) {
            return $this->sendError(__('general.tenant_detail.not_active_tenant'));
        }

        // @TODO discuss if already active,
        $user->password = bcrypt($request->password);
        $user->save();
        return $this->sendResponse($user->tenant->id, __('models.tenant.saved'));
    }

    /**

     * @SWG\Post(
     *      path="/addReview",
     *      summary="Update Tenant review and rating",
     *      tags={"Tenant"},
     *      description="Update Tenant review and rating",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="tenant_id",
     *          description="tenant_id of Tenant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="rating",
     *          description="rating of Tenant",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="review",
     *          description="review of Tenant",
     *          type="string",
     *          required=true,
     *          in="path"
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
     *                  example="Tenant not found"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successfully updated",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example="true"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="integer",
     *                  example=1
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function addReview(Request $request){
        $input = $request->all();
        $tenant = $this->tenantRepository->findWithoutFail($input['tenant_id']);
        
        if (empty($tenant)) {
            return $this->sendError(__('models.tenant.errors.not_found'));
        }
        $data['review']=$input['review'];
        $data['rating']=$input['rating'];
        Tenant::where('id',$input['tenant_id'])->update($data);
        
        return $this->sendResponse($input['tenant_id'], __('models.tenant.saved'));
    }
}
