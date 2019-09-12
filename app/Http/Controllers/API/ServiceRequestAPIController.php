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
use App\Http\Requests\API\ServiceRequest\UpdateRequest;
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
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
     * ServiceRequestAPIController constructor.
     * @param ServiceRequestRepository $serviceRequestRepo
     */
    public function __construct(ServiceRequestRepository $serviceRequestRepo)
    {
        $this->serviceRequestRepository = $serviceRequestRepo;
    }

    /**
     * @param ListRequest $request
     * @return Response
     * @throws Exception
     *
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
     * @param CreateRequest $request
     * @return Response
     * @throws Exception
     *
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
     * @param int $id
     * @return Response
     *
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
     */
    public function show($id)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $serviceRequest->load([
            'media', 'tenant.user', 'tenant.building', 'category', 'managers', 'users',
            'comments.user', 'providers.address:id,country_id,state_id,city,street,zip', 'providers',
        ]);
        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, 'Service Request retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return Response
     * @throws Exception
     *
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

        $attr = $this->serviceRequestRepository->getPutAttributes($input, $serviceRequest);
        $updatedServiceRequest = $this->serviceRequestRepository->update($attr, $id);
        $this->serviceRequestRepository->notifyStatusChange($serviceRequest, $updatedServiceRequest);

        if ($updatedServiceRequest->due_date && $updatedServiceRequest->due_date != $serviceRequest->due_date) {
            $this->serviceRequestRepository->notifyDue($updatedServiceRequest);
        }

        $updatedServiceRequest->load([
            'media', 'tenant.user', 'category', 'managers.user', 'users',
            'comments.user', 'providers.address:id,country_id,state_id,city,street,zip', 'providers.user',
        ]);
        $response = (new ServiceRequestTransformer)->transform($updatedServiceRequest);
        return $this->sendResponse($response, __('models.request.saved'));
    }

    /**
     * @param int $id
     * @param ChangeStatusRequest $request
     * @return Response
     * @throws Exception
     *
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
     */
    public function changeStatus(int $id, ChangeStatusRequest $request)
    {
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($serviceRequest)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $input = ['status' => $request->get('status', '')];
        $input = $this->serviceRequestRepository->getStatusRelatedAttributes($input, $serviceRequest);

        if (!$this->serviceRequestRepository->checkStatusPermission($input, $serviceRequest->status)) {
            return $this->sendError(__('models.request.errors.not_allowed_change_status'));
        }

        $serviceRequest = $this->serviceRequestRepository->update($input, $id);
        $response = (new ServiceRequestTransformer)->transform($serviceRequest);
        return $this->sendResponse($response, __('models.request.status_changed'));
    }

    /**
     * @param int $id
     * @param ChangePriorityRequest $request
     * @return Response
     * @throws Exception
     *
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
     * @param int $id
     * @return Response
     *
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
    public function destroyWithIds(Request $request){
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
     * @param int $id
     * @param NotifyProviderRequest $request
     * @param ServiceProviderRepository $spRepo
     * @return Response
     *
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
     */
    public function notifyProvider(int $id, NotifyProviderRequest $request,
                                   ServiceProviderRepository $spRepo,
                                   PropertyManagerRepository $pmRepo)
    {
        $sr = $this->serviceRequestRepository->findWithoutFail($id);
        if (empty($sr)) {
            return $this->sendError(__('models.request.errors.not_found'));
        }

        $providerId = $request->service_provider_id ?? $request->provider_id; // @TODO delete provider_id
        $sp = $spRepo->findWithoutFail($providerId);
        if (empty($sp)) {
            return $this->sendError(__('models.request.errors.provider_not_found'));
        }

        $managerId = $request->property_manager_id ?? $request->manager_id ?? $request->assignee_id ?? []; // @TODO delete manager_id, assignee_id
        $propertyManager = $pmRepo->with('user:email,id')->find($managerId);
        $mailDetails = $request->only(['title', 'to', 'cc', 'bcc', 'body']);
        $this->serviceRequestRepository->notifyProvider($sr, $sp, $propertyManager, $mailDetails);

        return $this->sendResponse($sr, __('models.request.mail.success'));
    }

    /**
     * @param int $id
     * @param int $pid
     * @param AssignRequest $request
     * @param ServiceProviderRepository $spRepo
     * @return Response
     *
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

        return $this->sendResponse($sr, __('general.attached.service'));
    }

    /**
     * @param int $id
     * @param int $pid
     * @param AssignRequest $request
     * @param ServiceProviderRepository $spRepo
     * @return Response
     *
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
     */
    public function unassignProvider(int $id, int $pid, ServiceProviderRepository $spRepo, AssignRequest $r)
    {
        return $this->deleteRequestAssignee($pid, $r);
    }

    /**
     * @param int $id
     * @param int $uid
     * @param UserRepository $uRepo
     * @param AssignRequest $r
     * @return Response
     *
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

        return $this->sendResponse($sr, __('general.attached.user'));
    }

    /**
     * @TODO delete this method
     * @SWG\Post(
     *      path="/requests/{id}/assignees/{uid}",
     *      summary="Assign the provided user to the request",
     *      tags={"ServiceRequest"},
     *      description="use <a href='http://dev.propify.ch/api/docs#/ServiceRequest/post_requests__id__managers__pmid_'>/requests/{id}/managers/{pmid}</a>",
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
     * @param int $id
     * @param int $uid
     * @param UserRepository $uRepo
     * @param AssignRequest $r
     * @return Response
     *
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

        return $this->sendResponse($sr, __('general.attached.manager'));
    }

    /**
     * @param int $id
     * @param int $uid
     * @param AssignRequest $r
     * @param UserRepository $uRepo
     * @return Response
     *
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
     */
    public function unassignUser(int $id, int $uid, UserRepository $uRepo, AssignRequest $r)
    {
        return $this->deleteRequestAssignee($uid, $r);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     *
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
     */
    public function getTags(int $id, Request $request)
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
     * @param int $id
     * @param int $tid
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     *
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
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.attached.tag'));
    }

    /**
     * @param int $id
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
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
        }

        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.attached.tag'));
    }

    /**
     * @param int $id
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
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
     */
    public function unassignManyTags(int $id, TagRepository $tRepo, AssignRequest $r)
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
        }

        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.detached.tag'));
    }

    /**
     * @param int $id
     * @param int $tid
     * @param TagRepository $tRepo
     * @param AssignRequest $r
     * @return mixed
     *
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
     */
    public function unassignTag(int $id, int $tid, TagRepository $tRepo, AssignRequest $r)
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
        $sr->load('media', 'tenant.user', 'category', 'comments.user', 'users',
            'providers.address:id,country_id,state_id,city,street,zip', 'providers.user', 'managers.user', 'tags');

        return $this->sendResponse($sr, __('general.detached.tag'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws Exception
     *
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
     */
    public function getAssignees(int $id, Request $request)
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
     * @param AssignRequest $request
     * @return mixed
     */
    public function deleteRequestAssignee(int $id, AssignRequest $request)
    {
        $requestAssignee = ServiceRequestAssignee::find($id);
        if (empty($requestAssignee)) {
            // @TODO fix message
            return $this->sendError(__('models.request.errors.not_found'));
        }
        $requestAssignee->delete();

        return $this->sendResponse($id, __('general.detached.' . $requestAssignee->assignee_type));
    }


    /**
     * @param int $id
     * @param TemplateRepository $tempRepo
     *
     * @return Response
     *
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
     */
    public function getCommunicationTemplates($id, TemplateRepository $tempRepo)
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
     * @param int $id
     * @param TemplateRepository $tempRepo
     *
     * @return Response
     *
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
     */
    public function getServiceCommunicationTemplates($id, TemplateRepository $tempRepo)
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
     * @param int $id
     * @param TemplateRepository $tempRepo
     *
     * @return Response
     *
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
     */
    public function getServiceEmailTemplates($id, TemplateRepository $tempRepo)
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
     * @param int $id
     * @param TemplateRepository $tempRepo
     *
     * @return Response
     *
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

}
