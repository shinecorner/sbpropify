<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Common\WhereInCriteria;
use App\Criteria\ServiceRequests\FilterByInternalFieldsCriteria;
use App\Criteria\ServiceRequests\FilterByPermissionsCriteria;
use App\Criteria\ServiceRequests\FilterByRelatedFieldsCriteria;
use App\Criteria\ServiceRequests\FilterNotAssignedCriteria;
use App\Criteria\ServiceRequests\FilterPendingCriteria;
use App\Criteria\ServiceRequests\FilterPublicCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\ServiceRequest\AssignRequest;
use App\Http\Requests\API\ServiceRequest\ChangePriorityRequest;
use App\Http\Requests\API\ServiceRequest\ChangeStatusRequest;
use App\Http\Requests\API\ServiceRequest\CreateRequest;
use App\Http\Requests\API\ServiceRequest\DeleteRequest;
use App\Http\Requests\API\ServiceRequest\ListRequest;
use App\Http\Requests\API\ServiceRequest\NotifyProviderRequest;
use App\Http\Requests\API\ServiceRequest\SeeRequestsCount;
use App\Http\Requests\API\ServiceRequest\UnAssignRequest;
use App\Http\Requests\API\ServiceRequest\UpdateRequest;
use App\Http\Requests\API\ServiceRequest\ViewRequest;
use App\Models\PropertyManager;
use App\Models\ServiceProvider;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssignee;
use App\Models\User;
use App\Repositories\PropertyManagerRepository;
use App\Repositories\ServiceProviderRepository;
use App\Repositories\ServiceRequestRepository;
use App\Repositories\TagRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\UserRepository;
use App\Transformers\ServiceRequestAssigneeTransformer;
use App\Transformers\ServiceRequestTransformer;
use App\Transformers\TagTransformer;
use App\Transformers\TemplateTransformer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class ServiceRequestController
 * @package App\Http\Controllers\API
 */
class ServiceRequestAPIController extends AppBaseController
{
    /** @var  ServiceRequestRepository */
    private $serviceRequestRepository;

    /**
     * @var string
     */
    private $serviceRequestFileNotFound = "Service request file not found!";

    /**
     * ServiceRequestAPIController constructor.
     * @param ServiceRequestRepository $serviceRequestRepo
     */
    public function __construct(ServiceRequestRepository $serviceRequestRepo)
    {
        $this->serviceRequestRepository = $serviceRequestRepo;
    }

    /**
     * @SWG\Get(
     *      path="/requests",
     *      summary="Get a listing of the ServiceRequests.",
     *      tags={"ServiceRequest"},
     *      description="Get all ServiceRequests",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="service_provider_id",
     *          in="query",
     *          type="integer",
     *          description=" Filter by ServiceProvider",
     *          required=false,
     *      ),
     *     @SWG\Parameter(
     *          name="property_manager_id",
     *          in="query",
     *          type="integer",
     *          description=" Filter by Property Manager",
     *          required=false,
     *      ),
     *     @SWG\Parameter(
     *          name="category_id",
     *          in="query",
     *          type="integer",
     *          description=" Filter by Category",
     *          required=false,
     *      ),
     *
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
     *                  @SWG\Items(ref="#/definitions/ServiceRequest")
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
    public function index(ListRequest $request)
    {
        $this->serviceRequestRepository->pushCriteria(new RequestCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterByPermissionsCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterByInternalFieldsCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterPublicCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterByRelatedFieldsCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterPendingCriteria($request));
        $this->serviceRequestRepository->pushCriteria(new FilterNotAssignedCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $serviceRequests = $this->serviceRequestRepository
                ->with('category')->get();
            $response = (new ServiceRequestTransformer)->transformCollection($serviceRequests);
            return $this->sendResponse($response, 'Service Requests retrieved successfully');
        }
        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $serviceRequests = $this->serviceRequestRepository
            ->with([
                'media',
                'tenant.user',
                'tenant.building.address',
                'tenant.rent_contracts' => function ($q) {
                    $q->with('building.address', 'unit');
                },
                'category',
                'comments.user',
                'providers.address:id,country_id,state_id,city,street,zip',
                'providers.user',
                'managers.user',
                'users'
            ])->paginate($perPage);

        $serviceRequests->getCollection()->loadCount('allComments');
        $response = (new ServiceRequestTransformer)->transformPaginator($serviceRequests);
        return $this->sendResponse($response, 'Service Requests retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/requests",
     *      summary="Store a newly created ServiceRequest in storage",
     *      tags={"ServiceRequest"},
     *      description="Store ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequest")
     *      ),
     *     @SWG\Parameter(
     *          name="media",
     *          in="body",
     *          description="Save media. You can pass media paramater
                                As string(base64) like **media=base64_string**,
                                as array of string(base64) like **media = [base64_string1, base64_string2, base64_string3, ...etc]**
                                or as array of array(media => string(base64)) like media = **[[media => base64_string1], [media => base64_string2], ...etc]**",
     *          required=false,
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="media",
     *                  description="id",
     *                  type="integer",
     *                  format="int32"
     *               ),
     *
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param CreateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        $input['internal_priority'] = $input['internal_priority'] ?? $input['priority'];
        $serviceRequest = $this->serviceRequestRepository->create($input);
        $this->serviceRequestRepository->notifyNewRequest($serviceRequest);
        if (isset($input['due_date'])) {
            $this->serviceRequestRepository->notifyDue($serviceRequest);
        }
        $serviceRequest->load([
            'media',
            'tenant.user',
            'tenant.building.address',
            'category',
            'comments.user',
            'providers.address:id,country_id,state_id,city,street,zip',
            'providers.user',
            'managers.user',
            'users'
        ]);
        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, __('models.request.saved'));
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}",
     *      summary="Display the specified ServiceRequest",
     *      tags={"ServiceRequest"},
     *      description="Get ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param ViewRequest $request
     * @return mixed
     */
    public function show($id, ViewRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);

        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->load([
            'media', 'tenant.user', 'tenant.building', 'category', 'managers', 'users', 'remainder_user',
            'comments.user', 'providers.address:id,country_id,state_id,city,street,zip', 'providers',
            'tenant.rent_contracts' => function ($q) {
                $q->with('building.address', 'unit');
            },
        ]);
        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, 'Service Request retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/requests/{id}",
     *      summary="Update the specified ServiceRequest in storage",
     *      tags={"ServiceRequest"},
     *      description="Update ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequest that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequest")
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateRequest $request)
    {
        $input = $request->only(ServiceRequest::Fillable);
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $oldStatus = $serviceRequest->status;
        if (!$this->serviceRequestRepository->checkStatusPermission($input, $oldStatus)) {
            return $this->sendError(__('models.request.errors.not_allowed_change_status'));
        }

        $updatedServiceRequest = $this->serviceRequestRepository->updateExisting($serviceRequest, $input);

        $updatedServiceRequest->load([
            'media', 'tenant.user', 'category', 'managers.user', 'users', 'remainder_user',
            'comments.user', 'providers.address:id,country_id,state_id,city,street,zip', 'providers.user',
        ]);
        $response = (new ServiceRequestTransformer)->transform($updatedServiceRequest);
        return $this->sendResponse($response, __('models.request.saved'));
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/changeStatus",
     *      summary="Change status on ServiceRequest",
     *      tags={"ServiceRequest"},
     *      description="Change status on ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequest")
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param ChangeStatusRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function changeStatus(int $id, ChangeStatusRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $input = ['status' => $request->get('status', '')];

        if (!$this->serviceRequestRepository->checkStatusPermission($input, $serviceRequest->status)) {
            return $this->sendError(__('models.request.errors.not_allowed_change_status'));
        }

        $serviceRequest = $this->serviceRequestRepository->updateExisting($serviceRequest, $input);
        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, __('models.request.status_changed'));
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/changePriority",
     *      summary="Change status on ServiceRequest",
     *      tags={"ServiceRequest"},
     *      description="Change priority on ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequest")
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param ChangePriorityRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function changePriority(int $id, ChangePriorityRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $input = [
            'priority' => $request->get('priority', '')
        ];

        $serviceRequest = $this->serviceRequestRepository->update($input, $id);

        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, __('models.request.priority_changed'));
    }

    /**
     * @SWG\Delete(
     *      path="/requests/{id}",
     *      summary="Remove the specified ServiceRequest from storage",
     *      tags={"ServiceRequest"},
     *      description="Delete ServiceRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
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
     *
     * @param $id
     * @param DeleteRequest $r
     * @return mixed
     * @throws Exception
     */
    public function destroy($id, DeleteRequest $r)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->delete();

        return $this->sendResponse($id, __('models.request.deleted'));
    }

    /**
     * @param DeleteRequest $request
     * @return mixed
     */
    public function destroyWithIds(DeleteRequest $request){
        $ids = $request->get('ids');
        try{
            ServiceRequest::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.request.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.request.deleted'));
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/notify",
     *      summary="Notify the provided service provider",
     *      tags={"ServiceRequest"},
     *      description="Notify the provided service provider",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="provider_id",
     *          in="body",
     *          description="ServiceProvider id",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceProvider")
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
     *                  ref="#/definitions/ServiceProvider"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param NotifyProviderRequest $request
     * @param ServiceProviderRepository $spRepo
     * @param PropertyManagerRepository $pmRepo
     * @return mixed
     */
    public function notifyProvider(
        int $id,
        NotifyProviderRequest $request,
        ServiceProviderRepository $spRepo,
        PropertyManagerRepository $pmRepo
    )
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $providerId = $request->service_provider_id;
        $sp = $spRepo->findWithoutFail($providerId);
        if (empty($sp)) {
            return $this->sendError(__('models.request.errors.provider_not_found'));
        }

        $managerId = $request->property_manager_id;

        $propertyManager = $managerId ? $pmRepo->with('user:email,id')->find($managerId) : null;
        $mailDetails = $request->only(['title', 'to', 'cc', 'bcc', 'body']);

        $this->serviceRequestRepository->notifyProvider($sr, $sp, $propertyManager, $mailDetails);
        $sr->touch();
        $sp->touch();
        return $this->sendResponse($sr, __('models.request.mail.success'));
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/providers/{pid}",
     *      summary="Assign the provided service provider to the request",
     *      tags={"ServiceRequest"},
     *      description="Assign the provided service provider to the request",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $pid
     * @param ServiceProviderRepository $spRepo
     * @param AssignRequest $r
     * @return mixed
     */
    public function assignProvider(int $id, int $pid, ServiceProviderRepository $spRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }
        $sp = $spRepo->findWithoutFail($pid);
        if (empty($sp)) {
            return $this->sendError(__('models.request.errors.provider_not_found'));
        }

        $sr->providers()->sync([$pid => ['created_at' => now()]], false);
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user');

        foreach ($sr->managers as $manager) {
            if ($manager->user) {
                $sr->conversationFor($manager->user, $sp->user);
            }
        }

        $sr->conversationFor(Auth::user(), $sp->user);
        $sr->touch();
        $sp->touch();
        return $this->sendResponse($sr, __('general.attached.service'));
    }

    /**
     * @SWG\Delete(
     *      path="/requests/{id}/providers/{pid}",
     *      summary="Unassign the provided service provider from the request",
     *      tags={"ServiceRequest"},
     *      description="use <a href='http://dev.propify.ch/api/docs#/ServiceRequest/delete_requests_assignees__requests_assignee_id_'>/requests-assignees/{requests_assignee_id}</a>",
     *      deprecated=true,
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $pid
     * @param ServiceProviderRepository $spRepo
     * @param UnAssignRequest $r
     * @return mixed
     */
    public function unassignProvider(int $id, int $pid, ServiceProviderRepository $spRepo, UnAssignRequest $r)
    {
        return $this->deleteRequestAssignee($pid, $r);
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/users/{user_id}",
     *      summary="Assign admin user to the request",
     *      tags={"ServiceRequest"},
     *      description="Assign admin user to the request",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $uid
     * @param UserRepository $uRepo
     * @param AssignRequest $r
     * @return Response
     */
    public function assignUser(int $id, int $uid, UserRepository $uRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $u = $uRepo->findWithoutFail($uid);
        if (empty($u)) {
            return $this->sendError(__('models.request.errors.user_not_found'));
        }
        // @TODO check admin or super admin

        $sr->users()->sync([$uid => ['created_at' => now()]], false);
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user');

        foreach ($sr->providers as $p) {
            $sr->conversationFor($p->user, $u);
        }

        $sr->touch();
        $u->touch();
        return $this->sendResponse($sr, __('general.attached.user'));
    }

    /**
     * @TODO delete this method
     * @SWG\Post(
     *      path="/requests/{id}/assignees/{uid}",
     *      summary="Assign the provided user to the request",
     *      tags={"ServiceRequest"},
     *      description="use <a href='http://dev.propify.ch/api/docs#/ServiceRequest/pinboard_requests__id__managers__pmid_'>/requests/{id}/managers/{pmid}</a>",
     *      deprecated=true,
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @param int $id
     * @param int $uid
     * @param UserRepository $uRepo
     * @param AssignRequest $r
     * @return mixed
     */
    public function assignTmpManager(int $id, int $uid, UserRepository $uRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $u = $uRepo->findWithoutFail($uid);
        if (empty($u)) {
            return $this->sendError(__('models.request.errors.user_not_found'));
        }

        // @TODO remove,
        $managerId = PropertyManager::where('user_id', $u->id)->value('id');
        return $this->assignManager($id, $managerId, $uRepo, $r);
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/managers/{pmid}",
     *      summary="Assign property manager to the request",
     *      tags={"ServiceRequest"},
     *      description="Assign property manager to the request",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $pmid
     * @param UserRepository $uRepo
     * @param AssignRequest $r
     * @return mixed
     */
    public function assignManager(int $id, int $pmid, UserRepository $uRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        // @TODO improve using repository,
        $manager = PropertyManager::with('user')->find($pmid);
        if (empty($manager)) {
            return $this->sendError(__('models.request.errors.user_not_found'));
        }

        $sr->managers()->sync([$pmid => ['created_at' => now()]], false);
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user');

        foreach ($sr->providers as $p) {
            $sr->conversationFor($p->user, $manager->user);
        }
        $sr->touch();
        $manager->touch();
        return $this->sendResponse($sr, __('general.attached.manager'));
    }

    /**
     * @SWG\Delete(
     *      path="/requests/{id}/assignees/{uid}",
     *      summary="Unassign the provided user to the request",
     *      tags={"ServiceRequest"},
     *      description="use <a href='http://dev.propify.ch/api/docs#/ServiceRequest/delete_requests_assignees__requests_assignee_id_'>/requests-assignees/{requests_assignee_id}</a>",
     *      deprecated=true,
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $uid
     * @param UserRepository $uRepo
     * @param UnAssignRequest $r
     * @return mixed
     */
    public function unassignUser(int $id, int $uid, UserRepository $uRepo, UnAssignRequest $r)
    {
        return $this->deleteRequestAssignee($uid, $r);
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}/tags",
     *      summary="Get a listing of the ServiceRequest tags.",
     *      tags={"ServiceRequest", "Tag"},
     *      description="Get a listing of the ServiceRequest tags.",
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
     *                  @SWG\Items(ref="#/definitions/Tag")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param ViewRequest $request
     * @return mixed
     */
    public function getTags(int $id, ViewRequest $request)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $tags = $sr->tags()->paginate($perPage);

        $response = (new TagTransformer())->transformPaginator($tags) ;
        return $this->sendResponse($response, 'Tags retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/tags/{tid}",
     *      summary="Assign the tag to the request",
     *      tags={"ServiceRequest", "Tag"},
     *      description="Assign the tag to the request",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $tid
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     */
    public function assignTag(int $id, int $tid, TagRepository $tRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $tag = $tRepo->findWithoutFail($tid);
        if (empty($tag)) {
            return $this->sendError(__('models.request.errors.tag_not_found'));
        }

        $sr->tags()->sync($tag, false);
        $sr->touch();
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.attached.tag'));
    }

    /**
     * @SWG\Post(
     *      path="/requests/{id}/tags",
     *      summary="Assign many tags to the request",
     *      tags={"ServiceRequest", "Tag"},
     *      description="Assign many tags to the request",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="tag_ids",
     *          description="ids of existing tags. Use or comma separated or array",
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="tags",
     *          description="name of tags. Use or comma separated or array. If Tag name is not exists that case must be create new tag",
     *          type="integer",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function assignManyTags(int $id, TagRepository $tRepo, AssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $tagIds = $r->tag_ids ?? [];

        if (!empty($r->tag_ids)) {
            $tagIds = is_array($r->tag_ids) ? $r->tag_ids : explode(',', $r->tag_ids);
            $tagIds = $tRepo->findWhereIn('id', $tagIds, ['id'])->pluck('id')->all();
        }

        if (!empty($r->tags)) {
            // check tag exist, if not create it and then get ids
            $tagNameList = is_array($r->tags) ? $r->tags : explode(',', $r->tags);
            $tagNameList = array_unique($tagNameList);
            $tags = $tRepo->findWhereIn('name', $tagNameList, ['id', 'name']);
            $tagIds = array_merge($tagIds, $tags->pluck('id')->all());
            $existingTags = $tags->pluck('name')->all();
            $notExistingTags = array_diff($tagNameList, $existingTags);

            foreach ($notExistingTags as $tagName) {
                $newTag = $tRepo->create(['name' => $tagName]);
                $tagIds[] = $newTag->id;
            }
        }

        if ($tagIds) {
            $sr->tags()->sync($tagIds, false);
            $sr->touch();
        }

        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.attached.tag'));
    }

    /**
     * @SWG\Delete(
     *      path="/requests/{id}/tags",
     *      summary="Un assign many tags from the request",
     *      tags={"ServiceRequest", "Tag"},
     *      description="Un assign many tags from the request",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="tag_ids",
     *          description="ids of existing tags. Use or comma separated or array",
     *          type="integer",
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="tags",
     *          description="name of tags. Use or comma separated or array. If Tag name is not exists that case must be create new tag",
     *          type="integer",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param TagRepository $tRepo
     * @param UnAssignRequest $r
     * @return mixed
     */
    public function unassignManyTags(int $id, TagRepository $tRepo, UnAssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $tagIds = $r->tag_ids ?? [];

        if (!empty($r->tag_ids)) {
            $tagIds = is_array($r->tag_ids) ? $r->tag_ids : explode(',', $r->tag_ids);
            $tagIds = $tRepo->findWhereIn('id', $tagIds, ['id'])->pluck('id')->all();
        }

        if (!empty($r->tags)) {
            // check tag exist, if not create it and then get ids
            $tagNameList = is_array($r->tags) ? $r->tags : explode(',', $r->tags);
            $tagNameList = array_unique($tagNameList);
            $tags = $tRepo->findWhereIn('name', $tagNameList, ['id']);
            $tagIds = array_merge($tagIds, $tags->pluck('id')->all());
        }

        if ($tagIds) {
            $sr->tags()->detach($tagIds);
            $sr->touch();
        }

        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.detached.tag'));
    }

    /**
     * @SWG\Delete(
     *      path="/requests/{id}/tags/{tid}",
     *      summary="Unassign single tag from the request",
     *      tags={"ServiceRequest", "Tag"},
     *      description="Unassign single tag from the request",
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
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param int $tid
     * @param TagRepository $tRepo
     * @param UnAssignRequest $r
     * @return mixed
     */
    public function unassignTag(int $id, int $tid, TagRepository $tRepo, UnAssignRequest $r)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $tag = $tRepo->findWithoutFail($tid);
        if (empty($tag)) {
            return $this->sendError(__('models.request.errors.tag_not_found'));
        }

        $sr->tags()->detach($tag);
        $sr->touch();
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.detached.tag'));
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}/assignees",
     *      summary="Get a listing of the ServiceRequest assignees.",
     *      tags={"ServiceRequest"},
     *      description="Get a listing of the ServiceRequest assignees.",
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
     *                  @SWG\Items(ref="#/definitions/ServiceRequestAssignee")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param ViewRequest $request
     * @return mixed
     */
    public function getAssignees(int $id, ViewRequest $request)
    {
        // @TODO permissions
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $assignees = $sr->assignees()->paginate($perPage);
        $assignees = $this->getAssigneesRelated($assignees, [PropertyManager::class, User::class, ServiceProvider::class]);

        $response = (new ServiceRequestAssigneeTransformer())->transformPaginator($assignees) ;
        return $this->sendResponse($response, 'Assignees retrieved successfully');
    }

    /**
     * @SWG\Delete(
     *      path="/requests-assignees/{requests_assignee_id}",
     *      summary="Unassign the provider,user or manager to the request",
     *      tags={"ServiceRequest", "User", "PropertyManager", "ServiceProvider"},
     *      description="Unassign the provider,user or manager to the request",
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
     *                  type="integer",
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param int $id
     * @param UnAssignRequest $request
     * @return mixed
     */
    public function deleteRequestAssignee(int $id, UnAssignRequest $request)
    {
        $requestAssignee = ServiceRequestAssignee::find($id);
        if (empty($requestAssignee)) {
            // @TODO fix message
            return $this->sendError(__('models.request.errors.not_found'));
        }
        $sr = ServiceRequest::find($requestAssignee->request_id);
        if ($sr) {
            $sr->touch();
        }

        $type = $requestAssignee->assignee_type;
        $class = Relation::$morphMap[$type] ?? $type;
        if (class_exists($class)) {
            $model = $class::find($requestAssignee->assignee_id);
            if ($model) {
                $model->touch();
            }
        }
        $requestAssignee->delete();

        return $this->sendResponse($id, __('general.detached.' . $requestAssignee->assignee_type));
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}/comunicationTemplates",
     *      summary="Display the list of Comunication templates filled with request data",
     *      tags={"ServiceRequest"},
     *      description="Get CommunicationTemplates",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
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
     *
     *
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param TemplateRepository $tempRepo
     * @param ViewRequest $request
     * @return mixed
     */
    public function getCommunicationTemplates($id, TemplateRepository $tempRepo, ViewRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->load([
            'media', 'tenant.user', 'tenant.building', 'category',
        ]);

        $templates = $tempRepo->getParsedCommunicationTemplates($serviceRequest, Auth::user());

        $response = (new TemplateTransformer)->transformCollection($templates);
        return $this->sendResponse($response, 'Communication Templates retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}/serviceComunicationTemplates",
     *      summary="Display the list of Service Comunication templates filled with request data",
     *      tags={"ServiceRequest"},
     *      description="Get Service Communication Templates",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
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
     *
     *
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param TemplateRepository $tempRepo
     * @param ViewRequest $request
     * @return mixed
     */
    public function getServiceCommunicationTemplates($id, TemplateRepository $tempRepo, ViewRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->load([
            'media', 'tenant.user', 'tenant.building', 'category',
        ]);

        $templates = $tempRepo->getParsedServiceCommunicationTemplates($serviceRequest, Auth::user());

        $response = (new TemplateTransformer)->transformCollection($templates);
        return $this->sendResponse($response, 'Service Communication Templates retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/requests/{id}/serviceemailTemplates",
     *      summary="Display the list of Service Email templates filled with request data",
     *      tags={"ServiceRequest"},
     *      description="Get Service Email Templates",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequest",
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
     *
     *
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ServiceRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     * @param $id
     * @param TemplateRepository $tempRepo
     * @param ViewRequest $request
     * @return mixed
     */
    public function getServiceEmailTemplates($id, TemplateRepository $tempRepo, ViewRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->load([
            'media', 'tenant.user', 'tenant.building', 'category',
        ]);

        $templates = $tempRepo->getParsedServiceEmailTemplates($serviceRequest, Auth::user());

        $response = (new TemplateTransformer)->transformCollection($templates);
        return $this->sendResponse($response, 'Service Email Templates retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/requestsCounts",
     *      summary="get recuests count",
     *      tags={"ServiceRequest"},
     *      description="Get request count when logged as admin and property manager",
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
     *                  type="object",
     *                  @SWG\Property(
     *                      property="all_request_count",
     *                      type="number",
     *                  ),
     *                  @SWG\Property(
     *                      property="all_unassigned_request_count",
     *                      type="number",
     *                  ),
     *                  @SWG\Property(
     *                      property="all_pending_request_count",
     *                      type="number",
     *                  ),
     *                  @SWG\Property(
     *                      property="my_request_count",
     *                      type="number",
     *                      description="This key exists when logged as property manager"
     *                  ),
     *                  @SWG\Property(
     *                      property="my_pending_request_count",
     *                      type="number",
     *                      description="This key exists when logged as property manager"
     *                  ),
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     *
     *
     * @param SeeRequestsCount $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function requestsCounts(SeeRequestsCount $request)
    {
        $requestCount = $this->serviceRequestRepository->count();

        $this->serviceRequestRepository->resetCriteria();
        $this->serviceRequestRepository->doesntHave('assignees');
        $notAssignedRequestsCount = $this->serviceRequestRepository->count();

        $pendingStatues = ServiceRequest::PendingStatuses;

        $this->serviceRequestRepository->resetCriteria();
        $this->serviceRequestRepository->pushCriteria(new WhereInCriteria('status', $pendingStatues));
        $allPendingCount = $this->serviceRequestRepository->count();

        $response = [
            'all_request_count' => $requestCount,
            'all_unassigned_request_count' => $notAssignedRequestsCount,
            'all_pending_request_count' => $allPendingCount
        ];

        $user = $request->user();
        if ($user->propertyManager()->exists()) {
            $response = $this->getLoggedRequestCount($user, $response, 'propertyManager', 'managers');
        } elseif ($user->serviceProvider()->exists()) {
            $response = $this->getLoggedRequestCount($user, $response, 'serviceProvider', 'providers');
        }

        return $this->sendResponse($response, 'Request countes');
    }

    /**
     * @param $user
     * @param $response
     * @param $userRelation
     * @param $requestRelation
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    protected function getLoggedRequestCount($user, $response, $userRelation, $requestRelation)
    {

        $relationId = $user->{$userRelation}->id;
        $this->serviceRequestRepository->resetCriteria();
        $this->serviceRequestRepository->whereHas($requestRelation, function ($q) use ($relationId) {
            $q->where('assignee_id', $relationId);
        });
        $response['my_request_count'] = $this->serviceRequestRepository->count();


        $this->serviceRequestRepository->resetCriteria();
        $this->serviceRequestRepository->whereHas($requestRelation, function ($q) use ($relationId) {
            $q->where('assignee_id', $relationId);
        });
        $this->serviceRequestRepository->pushCriteria(new WhereInCriteria('status', ServiceRequest::PendingStatuses));
        $response['my_pending_request_count'] = $this->serviceRequestRepository->count();

        return $response;
    }

    /**
     * @param $tenant
     * @return mixed
     */
    protected function getPdfName(ServiceRequest $serviceRequest)
    {
        $serviceRequest->setDownloadPdf();
        $pdfName = $serviceRequest->pdfFileName();

        return $pdfName ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadPdf($id){

        $r = $this->serviceRequestRepository->findWithoutFail($id);

        if (empty($r)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $pdfName = $this->getPdfName($r);
        if (!\Storage::disk('service_request_downloads')->exists($pdfName)) {
            return $this->sendError($this->serviceRequestFileNotFound);
        }
        return \Storage::disk('service_request_downloads')->download($pdfName, $pdfName);
    }

}
