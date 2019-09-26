<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\SRequestCategory\CreateRequest;
use App\Http\Requests\API\SRequestCategory\DeleteRequest;
use App\Http\Requests\API\SRequestCategory\ListRequest;
use App\Http\Requests\API\SRequestCategory\UpdateRequest;
use App\Http\Requests\API\SRequestCategory\ViewRequest;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use App\Repositories\ServiceRequestCategoryRepository;
use App\Transformers\ServiceRequestCategoryTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ServiceRequestCategoryController
 * @package App\Http\Controllers\API
 */
class ServiceRequestCategoryAPIController extends AppBaseController
{
    /** @var  ServiceRequestCategoryRepository */
    private $serviceRequestCategoryRepository;

    /**
     * ServiceRequestCategoryAPIController constructor.
     * @param ServiceRequestCategoryRepository $serviceRequestCategoryRepo
     */
    public function __construct(ServiceRequestCategoryRepository $serviceRequestCategoryRepo)
    {
        $this->serviceRequestCategoryRepository = $serviceRequestCategoryRepo;
    }

    /**
     * @SWG\Get(
     *      path="/requestCategories",
     *      summary="Get a listing of the ServiceRequestCategories.",
     *      tags={"ServiceRequestCategory"},
     *      description="Get all ServiceRequestCategories",
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
     *                  @SWG\Items(ref="#/definitions/ServiceRequestCategory")
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
     * @return Response
     * @throws \Exception
     */
    public function index(ListRequest $request)
    {
        $this->serviceRequestCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->serviceRequestCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

        $parentServiceRequestCategories = $this->serviceRequestCategoryRepository->with('categories')
            ->findWhere([
                'parent_id' => null
            ]);

        $tree = $request->get('tree', false);
        if ($tree) {
            $serviceRequestCategories = new Collection();

            foreach ($parentServiceRequestCategories as $parent) {
                $serviceRequestCategories->push($parent);
                if ($parent->categories) {
                    foreach ($parent->categories as $children) {
                        $serviceRequestCategories->push($children);
                    }
                }
            }

            $response = (new ServiceRequestCategoryTransformer())->transformCollection($serviceRequestCategories);
            return $this->sendResponse($response, 'Service Requests Categories retrieved successfully');
        }

        $response = (new ServiceRequestCategoryTransformer())->transformCollection($parentServiceRequestCategories);
        return $this->sendResponse($response, 'Service Request Categories retrieved successfully');
    }

    /**
     * @SWG\Get(
     *      path="/categoryTree",
     *      summary="Get a Tree listing of the ServiceRequestCategories.",
     *      tags={"ServiceRequestCategory"},
     *      description="Get all ServiceRequestCategories",
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
     *                  @SWG\Items(ref="#/definitions/ServiceRequestCategory")
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
     * @return Response
     * @throws \Exception
     */
    public function categoryTree(ListRequest $request)
    {
        $this->serviceRequestCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->serviceRequestCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));

        $serviceRequestCategories = $this->serviceRequestCategoryRepository->with('categories')
            ->findWhere([
                'parent_id' => null
            ]);

        $response = (new ServiceRequestCategoryTransformer())->transformCollection($serviceRequestCategories);

        return $this->sendResponse($response, 'Service Requests Categories retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/requestCategories",
     *      summary="Store a newly created ServiceRequestCategory in storage",
     *      tags={"ServiceRequestCategory"},
     *      description="Store ServiceRequestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequestCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequestCategory")
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
     *                  ref="#/definitions/ServiceRequestCategory"
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
     * @return Response
     * @throws \Exception
     */
    public function store(CreateRequest $request)
    {
        $input = $request->only((new ServiceRequestCategory)->getFillable());
        $input['has_qualifications'] = false;

        $parentId = $request->get('parent_id');
        if ($parentId) {
            /** @var ServiceRequestCategory $serviceRequestCategory */
            $parentCategory = $this->serviceRequestCategoryRepository->findWithoutFail((int)$parentId);
            if (empty($parentCategory)) {
                return $this->sendError(__('models.requestCategory.errors.parent_not_found'));
            }

            if ($parentCategory->parent_id) {
                return $this->sendError(__('models.requestCategory.errors.multiple_level_not_found'));
            }

            $input['has_qualifications'] = $parentCategory->has_qualifications;
        }

        $serviceRequestCategories = $this->serviceRequestCategoryRepository->create($input);

        $response = (new ServiceRequestCategoryTransformer)->transform($serviceRequestCategories);
        return $this->sendResponse($response, __('models.user.serviceRequestCategorySaved'));
    }

    /**
     * @SWG\Get(
     *      path="/requestCategories/{id}",
     *      summary="Display the specified ServiceRequestCategory",
     *      tags={"ServiceRequestCategory"},
     *      description="Get ServiceRequestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequestCategory",
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
     *                  ref="#/definitions/ServiceRequestCategory"
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
     * @param ViewRequest $r
     * @return mixed
     */
    public function show($id, ViewRequest $r)
    {
        /** @var ServiceRequestCategory $serviceRequestCategory */
        $serviceRequestCategory = $this->serviceRequestCategoryRepository->findWithoutFail($id);
        if (empty($serviceRequestCategory)) {
            return $this->sendError(__('models.requestCategory.errors.not_found'));
        }

        $response = (new ServiceRequestCategoryTransformer)->transform($serviceRequestCategory);
        return $this->sendResponse($response, 'Service Request Category retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/requestCategories/{id}",
     *      summary="Update the specified ServiceRequestCategory in storage",
     *      tags={"ServiceRequestCategory"},
     *      description="Update ServiceRequestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequestCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ServiceRequestCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ServiceRequestCategory")
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
     *                  ref="#/definitions/ServiceRequestCategory"
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
     * @param UpdateRequest $request
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(int $id, UpdateRequest $request)
    {
        $input = $request->only((new ServiceRequestCategory)->getFillable());

        /** @var ServiceRequestCategory $serviceRequestCategory */
        $serviceRequestCategory = $this->serviceRequestCategoryRepository->findWithoutFail($id);
        if (empty($serviceRequestCategory)) {
            return $this->sendError(__('models.requestCategory.errors.not_found'));
        }

        $input['has_qualifications'] = $serviceRequestCategory->has_qualifications;

        $parentId = $request->get('parent_id');
        if ($parentId) {
            /** @var ServiceRequestCategory $serviceRequestCategory */
            $parentCategory = $this->serviceRequestCategoryRepository->findWithoutFail((int)$parentId);
            if (empty($parentCategory)) {
                return $this->sendError(__('models.requestCategory.errors.parent_not_found'));
            }

            if ($parentCategory->parent_id) {
                return $this->sendError(__('models.requestCategory.errors.multiple_level_not_found'));
            }

            $input['has_qualifications'] = $parentCategory->has_qualifications;
        }

        $serviceRequestCategory = $this->serviceRequestCategoryRepository->update($input, $id);

        $response = (new ServiceRequestCategoryTransformer())->transform($serviceRequestCategory);
        return $this->sendResponse($response, __('models.user.serviceRequestCategorySaved'));
    }

    /**
     * @SWG\Delete(
     *      path="/requestCategories/{id}",
     *      summary="Remove the specified ServiceRequestCategory from storage",
     *      tags={"ServiceRequestCategory"},
     *      description="Delete ServiceRequestCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ServiceRequestCategory",
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
     * @param int $id
     * @param DeleteRequest $r
     * @return mixed
     * @throws \Exception
     */
    public function destroy(int $id, DeleteRequest $r)
    {
        /** @var ServiceRequestCategory $serviceRequestCategory */
        $serviceRequestCategory = $this->serviceRequestCategoryRepository->findWithoutFail($id);
        if (empty($serviceRequestCategory)) {
            return $this->sendError(__('models.requestCategory.errors.not_found'));
        }

        $usedCategory = ServiceRequest::where('category_id', $serviceRequestCategory->id)->first();
        if ($usedCategory) {
            return $this->sendError(__('models.requestCategory.errors.used_by_request'));
        }

        $serviceRequestCategory->delete();        
        return $this->sendResponse($id, __('models.user.serviceRequestCategoryDeleted'));
    }
}
