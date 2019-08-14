<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Common\WhereCriteria;
use App\Criteria\Tenants\FilterByBuildingCriteria;
use App\Criteria\Tenants\FilterByDistrictCriteria;
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
use App\Mails\SendTenantCredentials;
use App\Models\RealEstate;
use App\Models\Tenant;
use App\Models\User;
use App\Notifications\TenantCredentials;
use App\Repositories\PostRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\TenantRepository;
use App\Repositories\UserRepository;
use App\Transformers\TenantTransformer;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Validator;

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
        $this->tenantRepository->pushCriteria(new FilterByDistrictCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByStateCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByRequestCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByUnitCriteria($request));
        $this->tenantRepository->pushCriteria(new FilterByStatusCriteria($request));
        $this->tenantRepository->pushCriteria(new RequestCriteria($request));
        $this->tenantRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $request->merge(['limit' => env('APP_PAGINATE', 10)]);
            $this->tenantRepository->pushCriteria(new LimitOffsetCriteria($request));
            $tenants = $this->tenantRepository->get();
            return $this->sendResponse($tenants->toArray(), 'Tenants retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $tenants = $this->tenantRepository->with(['user', 'building.address', 'unit'])->paginate($perPage);

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
        $tenants = $this->tenantRepository->with('address:id,street,street_nr')->get(['id', 'address_id', 'first_name', 'last_name', 'status']);

        return $this->sendResponse($tenants->toArray(), 'Tenants retrieved successfully');
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
            $userPass = $input['user']['password'];
            $user = $this->userRepository->create($input['user']);
        } catch (\Exception $e) {
            return $this->sendError('Tenant create error: ' . $e->getMessage());
        }

        $input['user_id'] = $user->id;
        try {
            $tenant = $this->tenantRepository->create($input);
        } catch (\Exception $e) {
            return $this->sendError('Tenant create error: ' . $e->getMessage());
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
            return $this->sendError('Tenant not found');
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
            return $this->sendError('Tenant not found');
        }

        $user->tenant->load('user', 'building', 'unit', 'address', 'media');
        $response = (new TenantTransformer)->transform($user->tenant);

        return $this->sendResponse($response, 'Tenant retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return Response
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
        $tenant = $this->tenantRepository->with('user')->findWithoutFail($id);
        if (empty($tenant)) {
            return $this->sendError('Tenant not found');
        }

        $shouldPost = isset($input['unit_id']) && $input['unit_id'] != $tenant->unit_id;

        $input['user'] = $input['user'] ?? [];
        $input['user']['name'] = sprintf('%s %s', $input['first_name'], $input['last_name']);
        $input['user']['email'] = $input['email'];
        $userPass = $input['password'] ?? "";
        $validator = Validator::make($input['user'], User::$rulesUpdate);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        try {
            $this->userRepository->update($input['user'], $tenant->user_id);
        } catch (\Exception $e) {
            return $this->sendError('Tenant update error: ' . $e->getMessage());
        }

        try {
            $tenant = $this->tenantRepository->update($input, $id);
        } catch (\Exception $e) {
            return $this->sendError('Tenant create error: ' . $e->getMessage());
        }

        $tenant->load('user', 'building', 'unit', 'address', 'media');
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
            return $this->sendError('Tenant not found');
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
            return $this->sendError('Tenant update error: ' . $e->getMessage());
        }


        try {
            $tenant = $this->tenantRepository->update($input, $user->tenant->id);
        } catch (\Exception $e) {
            return $this->sendError('Tenant update error: ' . $e->getMessage());
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
            return $this->sendError('Tenant not found');
        }

        $validator = Validator::make($request->all(), ['status' => 'required|integer|in:1,2']);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input = [
            'status' => $request->get('status', '')
        ];

        if (!$this->tenantRepository->checkStatusPermission($input, $tenant->status)) {
            return $this->sendError('You are not allowed to change status');
        }

        if ($input['status'] == Tenant::StatusNotActive) {
            $input['building_id'] = null;
            $input['unit_id'] = null;
            // $input['address_id'] = null;
        }

        try {
            $tenant = $this->tenantRepository->update($input, $id);
        } catch (\Exception $e) {
            return $this->sendError('Tenant update error: ' . $e->getMessage());
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

    /**
     * @param $id
     * @param DownloadCredentialsRequest $r
     * @return mixed
     */
    public function downloadCredentials($id, DownloadCredentialsRequest $r)
    {
        $t = $this->tenantRepository->findForCredentials($id);
        if (empty($t)) {
            return $this->sendError('Tenant not found');
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
            return $this->sendError('Tenant not found');
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
            return $this->sendError('Tenant not found');
        }

        $user = $tenant->user;
        if($user->email == $request->email) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->sendResponse($tenant->id, __('models.tenant.password_reset'));
        } else {
            return $this->sendError('Incorrect email address');
        }
    }

    /**
     *
     * @SWG\Put(
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
            return $this->sendError('code, email, password required');
        }
        $this->tenantRepository->pushCriteria(new WhereCriteria('activation_code', $request->code));
        $tenant = $this->tenantRepository->with('user:id,email')->first();
        if (empty($tenant )) {
            return $this->sendError('Code is invalid');
        }
        // @TODO discuss if already active,
        $user = $tenant->user;
        if($user->email == $request->email) {
            $user->password = bcrypt($request->password);
            $user->save();
            return $this->sendResponse($tenant->id, __('models.tenant.saved'));
        } else {
            return $this->sendError('Incorrect email address');
        }
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
            return $this->sendError('Tenant not found');
        }
        $data['review']=$input['review'];
        $data['rating']=$input['rating'];
        Tenant::where('id',$input['tenant_id'])->update($data);
        
        return $this->sendResponse($input['tenant_id'], __('models.tenant.saved'));
    }
}
