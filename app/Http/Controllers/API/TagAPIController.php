<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Tag\CreateRequest;
use App\Http\Requests\API\Tag\UpdateRequest;
use App\Http\Requests\API\Tag\ListRequest;
use App\Http\Requests\API\Tag\ViewRequest;
use App\Http\Requests\API\Tag\DeleteRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use App\Transformers\TagTransformer;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Criteria\Common\RequestCriteria;

/**
 * Class TagController
 * @package App\Http\Controllers\API
 */
class TagAPIController extends AppBaseController
{
    /** @var  TagRepository */
    private $tagRepository;

    /**
     * TagAPIController constructor.
     * @param TagRepository $tagRepo
     */
    public function __construct(TagRepository $tagRepo)
    {
        $this->tagRepository = $tagRepo;
    }

    /**
     * @SWG\Get(
     *      path="/tags",
     *      summary="Get a listing of the Tags.",
     *      tags={"Tag"},
     *      description="Get all Tags",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="get_all",
     *          in="query",
     *          description="get all Tags",
     *          required=false,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *          name="search",
     *          in="query",
     *          description="search Tags by name (autosugestion)",
     *          required=false,
     *          type="string"
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
     * @param ListRequest $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(ListRequest $request)
    {
        $this->tagRepository->pushCriteria(new RequestCriteria($request));
        $this->tagRepository->pushCriteria(new LimitOffsetCriteria($request));

        $getAll = $request->get('get_all', false);
        if ($getAll) {
            $tags = $this->tagRepository->get();
            $response = (new TagTransformer)->transformCollection($tags);
            return $this->sendResponse($response, 'Tags retrieved successfully');
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $tags = $this->tagRepository->paginate($perPage);

        $response = (new TagTransformer)->transformPaginator($tags);
        return $this->sendResponse($response, 'Tags retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/tags",
     *      summary="Store a newly created Tag in storage",
     *      tags={"Tag"},
     *      description="Store Tag",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tag that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tag")
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
     *                  ref="#/definitions/Tag"
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateRequest $request)
    {
        $input = $request->all();
        $tag = $this->tagRepository->create($input);
        $response = (new TagTransformer)->transform($tag);

        return $this->sendResponse($response, __('models.tag.saved'));
    }

    /**
     * @SWG\Get(
     *      path="/tags/{id}",
     *      summary="Display the specified Tag",
     *      tags={"Tag"},
     *      description="Get Tag",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tag",
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
     *                  ref="#/definitions/Tag"
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function show($id, ViewRequest $r)
    {
        /** @var Tag $tag */
        $tag = $this->tagRepository->findWithoutFail($id);
        if (empty($tag)) {
            return $this->sendError(__('models.tag.errors.not_found'));
        }

        $response = (new TagTransformer)->transform($tag);

        return $this->sendResponse($response, 'Tag retrieved successfully');
    }

    /**
     * @SWG\Put(
     *      path="/tags/{id}",
     *      summary="Update the specified Tag in storage",
     *      tags={"Tag"},
     *      description="Update Tag",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tag",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Tag that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Tag")
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
     *                  ref="#/definitions/Tag"
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateRequest $request)
    {
        $input = $request->all();

        /** @var Tag $tag */
        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            return $this->sendError(__('models.tag.errors.not_found'));
        }

        $tag = $this->tagRepository->update($input, $id);

        $response = (new TagTransformer)->transform($tag);
        return $this->sendResponse($response, __('models.tag.saved'));
    }

    /**
     * @SWG\Delete(
     *      path="/tags/{id}",
     *      summary="Remove the specified Tag from storage",
     *      tags={"Tag"},
     *      description="Delete Tag",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Tag",
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
     * @throws \Exception
     */
    public function destroy($id, DeleteRequest $r)
    {
        /** @var Tag $tag */
        $tag = $this->tagRepository->findWithoutFail($id);

        if (empty($tag)) {
            return $this->sendError(__('models.tag.errors.not_found'));
        }

        $tag->delete();

        return $this->sendResponse($id, __('models.tag.deleted'));
    }
}
