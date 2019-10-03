<?php

namespace App\Http\Controllers\API;

use App\Criteria\Common\RequestCriteria;
use App\Criteria\Products\FilterByTenantCriteria;
use App\Criteria\Products\FilterByTypeCriteria;
use App\Criteria\Products\FilterByUserCriteria;
use App\Criteria\Products\FilterByStatusCriteria;
use App\Criteria\Products\FilterByQuarterCriteria;
use App\Http\Requests\API\Listing\LikeRequest;
use App\Http\Requests\API\Listing\ListRequest;
use App\Notifications\ProductLiked;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Listing\CreateRequest;
use App\Http\Requests\API\Listing\DeleteRequest;
use App\Http\Requests\API\Listing\PublishRequest;
use App\Http\Requests\API\Listing\UpdateRequest;
use App\Http\Requests\API\Listing\ViewRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\SettingsRepository;
use App\Transformers\ProductTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class ListingAPIController
 * @package App\Http\Controllers\API
 */
class ListingAPIController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;
    /**
     * @var SettingsRepository
     */
    private $settingsRepository;
    /**
     * @var ProductTransformer
     */
    private $transformer;
    /**
     * @var UserTransformer
     */
    private $uTransformer;

    /**
     * ListingAPIController constructor.
     * @param ProductRepository $productRepo
     * @param SettingsRepository $reRepo
     * @param ProductTransformer $t
     * @param UserTransformer $ut
     */
    public function __construct(
        ProductRepository $productRepo,
        SettingsRepository $reRepo,
        ProductTransformer $t,
        UserTransformer $ut
    )
    {
        $this->productRepository = $productRepo;
        $this->settingsRepository = $reRepo;
        $this->transformer = $t;
        $this->uTransformer = $ut;
    }

    /**
     * @SWG\Get(
     *      path="/products",
     *      summary="Get a listing of the Products.",
     *      tags={"Marketplace"},
     *      description="Get all Products",
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
     *                  @SWG\Items(ref="#/definitions/Listing")
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
        $this->productRepository->pushCriteria(new RequestCriteria($request));
        $this->productRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->productRepository->pushCriteria(new FilterByTenantCriteria($request));
        $this->productRepository->pushCriteria(new FilterByUserCriteria($request));
        $this->productRepository->pushCriteria(new FilterByTypeCriteria($request));
        $this->productRepository->pushCriteria(new FilterByStatusCriteria($request));
        $this->productRepository->pushCriteria(new FilterByQuarterCriteria($request));
        
        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $products = $this->productRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
        ])->orderBy('published_at', 'desc')->orderBy('created_at', 'desc')
            ->paginate($perPage);
        $products->getCollection()->loadCount('allComments');

        $out = $this->transformer->transformPaginator($products);
        return $this->sendResponse($out, 'Products retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/products",
     *      summary="Store a newly created Listing in storage",
     *      tags={"Marketplace"},
     *      description="Store Listing",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Listing that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Listing")
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
     *                  ref="#/definitions/Listing"
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
        $input = $request->all();
        $input['user_id'] = \Auth::id();
        $input['status'] = Product::StatusUnpublished;

        $settings = $this->settingsRepository->first();
        $input['needs_approval'] = false;
        if ($settings) {
            $input['needs_approval'] = $settings->marketplace_approval_enable;
        }

        $product = $this->productRepository->create($input);

        $data = $this->transformer->transform($product);
        return $this->sendResponse($data, __('models.product.saved'));
    }

    /**
     * @SWG\Get(
     *      path="/products/{id}",
     *      summary="Display the specified Listing",
     *      tags={"Marketplace"},
     *      description="Get Listing",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
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
     *                  ref="#/definitions/Listing"
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
        /** @var Product $product */
        $product = $this->productRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
        ])->withCount('allComments')->findWithoutFail($id);

        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }
        $product->likers = $product->collectLikers();

        $data = $this->transformer->transform($product);
        return $this->sendResponse($data, 'Listing retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/products/{id}",
     *      summary="Update the specified Listing in storage",
     *      tags={"Marketplace"},
     *      description="Update Listing",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Listing that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Listing")
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
     *                  ref="#/definitions/Listing"
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateRequest $request)
    {
        $input = $request->only(Product::Fillable);

        /** @var Product $product */
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }

        $product = $this->productRepository->update($input, $id);

        $data = $this->transformer->transform($product);
        return $this->sendResponse($data, __('models.product.saved'));
    }

    /**
     * @SWG\Delete(
     *      path="/products/{id}",
     *      summary="Remove the specified Listing from storage",
     *      tags={"Marketplace"},
     *      description="Delete Listing",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
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
     * @param DeleteRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id, DeleteRequest $request)
    {
        /** @var Product $product */
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }

        $product->delete();

        return $this->sendResponse($id, __('models.product.deleted'));
    }

    /**
     * @param DeleteRequest $request
     * @return mixed
     */
    public function destroyWithIds(DeleteRequest $request){
        $ids = $request->get('ids');
        try{
            Product::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.product.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.product.deleted'));
    }

    /**
     * @SWG\Post(
     *      path="/products/{id}/like",
     *      summary="Like a product",
     *      tags={"Marketplace"},
     *      description="Like a Listing",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
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
     *                  type="object",
     *                  description="logged in user"
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
     * @param LikeRequest $likeRequest
     * @return mixed
     */
    public function like($id, LikeRequest $likeRequest)
    {
        $product = $this->productRepository->findWithoutFail($id);
        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }

        $u = \Auth::user();
        $u->like($product);

        // if logged in user is tenant and
        // author of product is tenant and
        // author of product is different than liker
        if ($u->tenant && $product->user->tenant && $u->id != $product->user_id) {
            $product->user->notify(new ProductLiked($product, $u->tenant));
        }
        return $this->sendResponse($this->uTransformer->transform($u),
        __('models.product.liked'));
    }

    /**
     * @SWG\Post(
     *      path="/products/{id}/unlike",
     *      summary="Unlike a Listing",
     *      tags={"Marketplace"},
     *      description="Unlike a product",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
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
     *                  type="object",
     *                  description="logged in user"
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
     * @param LikeRequest $likeRequest
     * @return mixed
     */
    public function unlike($id, LikeRequest $likeRequest)
    {
        $product = $this->productRepository->findWithoutFail($id);
        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }

        $u = \Auth::user();
        $u->unlike($product);
        return $this->sendResponse($this->uTransformer->transform($u),
        __('models.product.unliked'));
    }

    /**
     * @SWG\Post(
     *      path="/products/{id}/publish",
     *      summary="Publish a product",
     *      tags={"Marketplace"},
     *      description="Publish a product",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Listing",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="status",
     *          in="body",
     *          type="integer",
     *          format="int32",
     *          description="The new status of the product",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/Listing")
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
     *                  ref="#/definitions/Listing"
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
     * @param PublishRequest $request
     * @return mixed
     */
    public function publish($id, PublishRequest $request)
    {
        $newStatus = $request->get('status');
        $product = $this->productRepository->findWithoutFail($id);
        if (empty($product)) {
            return $this->sendError(__('models.product.errors.not_found'));
        }

        $product = $this->productRepository->setStatusExisting($product, $newStatus);

        return $this->sendResponse($id, __('general.status_changed'));
    }
}
