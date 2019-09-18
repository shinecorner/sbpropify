<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Quarter\BatchAssignManagers;
use App\Http\Requests\API\Quarter\BatchAssignUsers;
use App\Http\Requests\API\Quarter\CreateRequest;
use App\Http\Requests\API\Quarter\UpdateRequest;
use App\Http\Requests\API\Quarter\ListRequest;
use App\Http\Requests\API\Quarter\ViewRequest;
use App\Http\Requests\API\Quarter\DeleteRequest;
use App\Models\PropertyManager;
use App\Models\Quarter;
use App\Models\User;
use App\Repositories\QuarterRepository;
use App\Transformers\QuarterAssigneeTransformer;
use App\Transformers\QuarterTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criteria\Common\RequestCriteria;

/**
 * Class QuarterController
 * @package App\Http\Controllers\API
 */
class QuarterAPIController extends AppBaseController
{
    /** @var  QuarterRepository */
    private $quarterRepository;

    public function __construct(QuarterRepository $quarterRepo)
    {
        $this->quarterRepository = $quarterRepo;
    }

    /**
     * @param ListRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/quarters",
     *      summary="Get a listing of the Quarters.",
     *      tags={"Quarter"},
     *      description="Get all Quarters",
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
     *                  @SWG\Items(ref="#/definitions/Quarter")
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
        $this->quarterRepository->pushCriteria(new RequestCriteria($request));
        $this->quarterRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $quarters = $this->quarterRepository->get();
            $response = (new QuarterTransformer)->transformCollection($quarters);
            return $this->sendResponse($response, 'Quarters retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $quarters = $this->quarterRepository->paginate($perPage);

        $response = (new QuarterTransformer)->transformPaginator($quarters);
        return $this->sendResponse($response, 'Quarters retrieved successfully');
    }

    /**
     * @param CreateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Post(
     *      path="/quarters",
     *      summary="Store a newly created Quarter in storage",
     *      tags={"Quarter"},
     *      description="Store Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Quarter that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Quarter")
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
     *                  ref="#/definitions/Quarter"
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
        $quarter = $this->quarterRepository->create($input);
        $response = (new QuarterTransformer)->transform($quarter);

        return $this->sendResponse($response, __('models.quarter.saved'));
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/quarters/{id}",
     *      summary="Display the specified Quarter",
     *      tags={"Quarter"},
     *      description="Get Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
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
     *                  ref="#/definitions/Quarter"
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
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);
        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $response = (new QuarterTransformer)->transform($quarter);

        return $this->sendResponse($response, 'Quarter retrieved successfully');
    }

    /**
     * @param $id
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Put(
     *      path="/quarters/{id}",
     *      summary="Update the specified Quarter in storage",
     *      tags={"Quarter"},
     *      description="Update Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Quarter that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Quarter")
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
     *                  ref="#/definitions/Quarter"
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
        $input = $request->all();

        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);

        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $quarter = $this->quarterRepository->updateExisting($quarter, $input);

        $response = (new QuarterTransformer)->transform($quarter);
        return $this->sendResponse($response, __('models.quarter.saved'));
    }

    /**
     * @param $id
     * @param DeleteRequest $r
     * @return mixed
     * @throws \Exception
     *
     *
     * @SWG\Delete(
     *      path="/quarters/{id}",
     *      summary="Remove the specified Quarter from storage",
     *      tags={"Quarter"},
     *      description="Delete Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Quarter",
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
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);

        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $quarter->delete();

        return $this->sendResponse($id, __('models.quarter.deleted'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyWithIds(Request $request){
        $ids = $request->get('ids');
        try{
            Quarter::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.quarter.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.quarter.deleted'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/quarters/{id}/assignees",
     *      summary="Get a listing of the Quarter assignees.",
     *      tags={"Quarter"},
     *      description="Get a listing of the Quarter assignees.",
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
     *                  @SWG\Items(ref="#/definitions/QuarterAssignee")
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
        $quarter = $this->quarterRepository->findWithoutFail($id);
        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $assignees = $quarter->assignees()->paginate($perPage);
        $assignees = $this->getAssigneesRelated($assignees, [PropertyManager::class, User::class]);

        $response = (new QuarterAssigneeTransformer())->transformPaginator($assignees) ;
        return $this->sendResponse($response, 'Assignees retrieved successfully');
    }

    /**
     * @param int $id
     * @param BatchAssignManagers $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/quarters/{id}/managers",
     *      summary="Assign the provided propertyManagers to the Quarter",
     *      tags={"Quarter"},
     *      description=" <a href='http://dev.propify.ch/api/docs#/Quarter/post_quarters__id__managers'>http://dev.propify.ch/api/docs#/Quarter/post_quarters__id__managers</a>",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="managerIds",
     *          description="ids of managers",
     *          type="array",
     *          required=true,
     *          in="query",
     *          @SWG\Items(
     *              type="integer"
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
     *                  ref="#/definitions/Quarter"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function assignManagers(int $id, BatchAssignManagers $request)
    {
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);
        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $managerIds = $request->get('managersIds') ?? $request->get('managerIds');
        try {
            $currentManagers = $quarter->propertyManagers()
                ->whereIn('property_managers.id', $managerIds)
                ->pluck('property_managers.id')
                ->toArray();

            $newManagers = array_diff($managerIds, $currentManagers);
            $attachData  = [];
            foreach ($newManagers as $manager) {
                $attachData[$manager] = ['created_at' => now()];
            }
            $quarter->propertyManagers()->syncWithoutDetaching($attachData);
        } catch (\Exception $e) {
            return $this->sendError( __('models.quarter.errors.manager_assigned') . $e->getMessage());
        }

        $response = (new QuarterTransformer)->transform($quarter);
        return $this->sendResponse($response, __('models.quarter.managers_assigned'));
    }

    /**
     * @param int $id
     * @param BatchAssignUsers $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/quarters/{id}/users",
     *      summary="Assign the provided users to the Quarter",
     *      tags={"Quarter"},
     *      description="Assign the provided users(administrator, super-administrator) to the Quarter",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="userIds",
     *          description="ids of users",
     *          type="array",
     *          required=true,
     *          in="query",
     *          @SWG\Items(
     *              type="integer"
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
     *                  ref="#/definitions/Quarter"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function assignUsers(int $id, BatchAssignUsers $request)
    {
        /** @var Quarter $quarter */
        $quarter = $this->quarterRepository->findWithoutFail($id);
        if (empty($quarter)) {
            return $this->sendError(__('models.quarter.errors.not_found'));
        }

        $userIds = $request->get('userIds');
        try {
            $currentUsers = $quarter->users()
                ->whereIn('users.id', $userIds)
                ->pluck('users.id')
                ->toArray();

            $newUsers = array_diff($userIds, $currentUsers);
            $attachData  = [];
            foreach ($newUsers as $userId) {
                $attachData[$userId] = ['created_at' => now()];
            }
            $quarter->users()->syncWithoutDetaching($attachData);
        } catch (\Exception $e) {
            return $this->sendError( __('models.quarter.errors.user_assigned') . $e->getMessage());
        }

        $response = (new QuarterTransformer)->transform($quarter);
        return $this->sendResponse($response, __('models.quarter.user_assigned'));
    }
}
