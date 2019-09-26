<?php

namespace App\Http\Controllers\API;

use App\Criteria\Pinboards\FeedCriteria;
use App\Criteria\Pinboards\FilterByBuildingCriteria;
use App\Criteria\Pinboards\FilterByQuarterCriteria;
use App\Criteria\Pinboards\FilterByLocationCriteria;
use App\Criteria\Pinboards\FilterByPinnedCriteria;
use App\Criteria\Pinboards\FilterByStatusCriteria;
use App\Criteria\Pinboards\FilterByTypeCriteria;
use App\Criteria\Pinboards\FilterByUserCriteria;
use App\Criteria\Pinboards\FilterByTenantCriteria;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\Pinboard\AssignRequest;
use App\Http\Requests\API\Pinboard\CreateRequest;
use App\Http\Requests\API\Pinboard\DeleteRequest;
use App\Http\Requests\API\Pinboard\LikeRequest;
use App\Http\Requests\API\Pinboard\ListRequest;
use App\Http\Requests\API\Pinboard\PublishRequest;
use App\Http\Requests\API\Pinboard\ShowRequest;
use App\Http\Requests\API\Pinboard\UnAssignRequest;
use App\Http\Requests\API\Pinboard\UpdateRequest;
use App\Http\Requests\API\Pinboard\ListViewsRequest;
use App\Http\Requests\API\Pinboard\ViewRequest;
use App\Models\Pinboard;
use App\Notifications\PostLiked;
use App\Repositories\BuildingRepository;
use App\Repositories\QuarterRepository;
use App\Repositories\PinboardRepository;
use App\Repositories\RealEstateRepository;
use App\Repositories\ServiceProviderRepository;
use App\Transformers\PostTransformer;
use App\Transformers\PostViewTransformer;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;

/**
 * Class PostController
 * @package App\Http\Controllers\API
 */
class PinboardAPIController extends AppBaseController
{
    /** @var  PinboardRepository */
    private $postRepository;
    /**
     * @var PostTransformer
     */
    private $transformer;
    /**
     * @var UserTransformer
     */
    private $uTransformer;

    /**
     * PinboardAPIController constructor.
     * @param PinboardRepository $postRepo
     * @param PostTransformer $pt
     * @param UserTransformer $ut
     */
    public function __construct(PinboardRepository $postRepo, PostTransformer $pt, UserTransformer $ut)
    {
        $this->postRepository = $postRepo;
        $this->transformer = $pt;
        $this->uTransformer = $ut;
    }

    /**
     * @SWG\Get(
     *      path="/posts",
     *      summary="Get a listing of the Pinboards.",
     *      tags={"Listing"},
     *      description="Get all Pinboards",
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
     *                  @SWG\Items(ref="#/definitions/Post")
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
     * @throws /Exception
     */
    public function index(ListRequest $request)
    {
        $this->postRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->postRepository->pushCriteria(new FeedCriteria($request));
        $this->postRepository->pushCriteria(new FilterByStatusCriteria($request));
        $this->postRepository->pushCriteria(new FilterByTypeCriteria($request));
        $this->postRepository->pushCriteria(new FilterByLocationCriteria($request));
        $this->postRepository->pushCriteria(new FilterByUserCriteria($request));
        $this->postRepository->pushCriteria(new FilterByQuarterCriteria($request));
        $this->postRepository->pushCriteria(new FilterByBuildingCriteria($request));
        $this->postRepository->pushCriteria(new FilterByPinnedCriteria($request));
        $this->postRepository->pushCriteria(new FilterByTenantCriteria($request));

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $posts = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'providers',
        ])->withCount('views')->paginate($perPage);
        $posts->getCollection()->loadCount('allComments');


        $out = $this->transformer->transformPaginator($posts);
        return $this->sendResponse($out, 'Pinboards retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/posts",
     *      summary="Store a newly created Post in storage",
     *      tags={"Listing"},
     *      description="Store Post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Post that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Post")
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
     *                  ref="#/definitions/Post"
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
     * @param RealEstateRepository $reRepo
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateRequest $request, RealEstateRepository $reRepo)
    {
        $input = $request->only(Pinboard::Fillable);
        $input['user_id'] = \Auth::id();

        if (! Auth::user()->hasRole('super_admin')) {
            $input['status'] = Pinboard::StatusNew;
        } else {
            $input['status'] = $input['status'] ?? Pinboard::StatusNew;
        }

        if ($request->pinned == 'true' || $request->pinned  == true) {
            $input['type'] = Pinboard::TypePinned;
        } else {
            $input['type'] =  $input['type'] ?? Pinboard::TypePost;
        }

        //$input['needs_approval'] = true; // @TODO
        $input['needs_approval'] = ! Auth::user()->hasRole('super_admin');
        if (! empty($input['type']) && $input['type'] == Pinboard::TypePost) {
            $input['notify_email'] = true;
            $realEstate = $reRepo->first();
            if ($realEstate) {
                $input['needs_approval'] = $realEstate->news_approval_enable;
            }
        }

        $post = $this->postRepository->create($input);
        $post->load([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
            'providers',
            'views',
        ])->loadCount('allComments');
        $data = $this->transformer->transform($post);

        return $this->sendResponse($data, __('models.post.saved'));
    }

    /**
     * @SWG\Get(
     *      path="/posts/{id}",
     *      summary="Display the specified Post",
     *      tags={"Listing"},
     *      description="Get Post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
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
     *                  ref="#/definitions/Post"
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
     * @param ShowRequest $request
     * @return mixed
     */
    public function show($id, ShowRequest $request)
    {
        /** @var Pinboard $post */
        $post = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
            'providers',
            'views',
        ])->withCount(['allComments', 'views'])->findWithoutFail($id);

        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $post->likers = $post->collectLikers();
        $this->fixPostViews($post);
        if ($post->pinned) {
            $post->load('pinned_email_receptionists');
        }
        $data = $this->transformer->transform($post);
        return $this->sendResponse($data, 'Post retrieved successfully');
    }

    /**
     * @param $post
     */
    protected function fixPostViews($post)
    {
        $tenantId = Auth::user()->tenant->id ?? null;
        if ($tenantId) {
            $postView = $post->views->where('tenant_id', $tenantId)->first();
            if (empty($postView)) {
                $postView = $post->views()->create(['tenant_id' => Auth::user()->tenant->id, 'views' => 1]);
                $post->views->push($postView);
            } else {
                $postView->update(['views' => $postView->views + 1]);
            }
        }
    }

    /**
     * @SWG\Put(
     *      path="/posts/{id}",
     *      summary="Update the specified Post in storage",
     *      tags={"Listing"},
     *      description="Update Post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Post that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Post")
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
     *                  ref="#/definitions/Post"
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
        $input = $request->only(Pinboard::Fillable);
        if ($request->pinned) {
            $input['type'] = Pinboard::TypePinned;
        } else {
            $input['type'] =  $input['type'] ?? Pinboard::TypePost;
        }

        $status = $request->get('status');

        /** @var Pinboard $post */
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $this->postRepository->updateExisting($post, $input);
        $post = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
            'providers',
            'views',
        ])->withCount('allComments')->findWithoutFail($id);
        $post->status = $status;
        $data = $this->transformer->transform($post);
        return $this->sendResponse($data, __('models.post.saved'));
    }

    /**
     * @SWG\Delete(
     *      path="/posts/{id}",
     *      summary="Remove the specified Post from storage",
     *      tags={"Listing"},
     *      description="Delete Post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
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
        /** @var Pinboard $post */
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $post->delete();

        return $this->sendResponse($id, __('models.post.deleted'));
    }

    /**
     * @param DeleteRequest $request
     * @return mixed
     */
    public function destroyWithIds(DeleteRequest $request){
        $ids = $request->get('ids');
        try{
            Pinboard::destroy($ids);
        }
        catch (\Exception $e) {
            return $this->sendError(__('models.post.errors.deleted') . $e->getMessage());
        }
        return $this->sendResponse($ids, __('models.post.deleted'));
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/publish",
     *      summary="Publish a post",
     *      tags={"Listing"},
     *      description="Publish a post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="status",
     *          in="body",
     *          type="integer",
     *          format="int32",
     *          description="The new status of the post",
     *          required=true,
     *          @SWG\Schema(ref="#/definitions/Post")
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
     *                  ref="#/definitions/Post"
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
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function publish($id, PublishRequest $request)
    {
        $newStatus = $request->get('status');
        $post = $this->postRepository->findWithoutFail($id);
        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $post = $this->postRepository->setStatusExisting($post, $newStatus, Carbon::now());

        return $this->sendResponse($post, __('general.status_changed'));
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/like",
     *      summary="Like a post",
     *      tags={"Listing"},
     *      description="Like a post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
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
     * @param LikeRequest $r
     * @return mixed
     */
    public function like($id, LikeRequest $r)
    {
        $post = $this->postRepository->findWithoutFail($id);
        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $u = \Auth::user();
        $u->like($post);

        // if logged in user is tenant and
        // author of post is tenant and
        // author of post is different than liker
        if ($u->tenant && $post->user->tenant && $u->id != $post->user_id) {
            $post->user->notify(new PostLiked($post, $u->tenant));
        }
        return $this->sendResponse($this->uTransformer->transform($u),
        __('models.post.liked'));
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/unlike",
     *      summary="Unlike a post",
     *      tags={"Listing"},
     *      description="Unlike a post",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Post",
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
     *                  type="integer",
     *                  description="count of likes for the post"
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
     * @param LikeRequest $r
     * @return mixed
     */
    public function unlike($id, LikeRequest $r)
    {
        $post = $this->postRepository->findWithoutFail($id);
        if (empty($post)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $u = \Auth::user();
        $u->unlike($post);
        return $this->sendResponse($this->uTransformer->transform($u),
        __('models.post.unliked'));
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/buildings/{bid}",
     *      summary="Assign the provided building to the post",
     *      tags={"Listing"},
     *      description="Assign the provided building to the post",
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
     *                  ref="#/definitions/Post"
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
     * @param int $bid
     * @param BuildingRepository $bRepo
     * @param AssignRequest $r
     * @return mixed
     */
    public function assignBuilding(int $id, int $bid, BuildingRepository $bRepo, AssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $b = $bRepo->findWithoutFail($bid);
        if (empty($b)) {
            return $this->sendError(__('models.post.errors.building_not_found'));
        }

        $p->buildings()->sync($b, false);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();


        return $this->sendResponse($p, __('general.attached.building'));
    }

    /**
     * @SWG\Delete(
     *      path="/posts/{id}/buildings/{bid}",
     *      summary="Unassign the provided building to the post",
     *      tags={"Listing"},
     *      description="Unassign the provided building to the post",
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
     *                  ref="#/definitions/Post"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @param int $id
     * @param int $bid
     * @param BuildingRepository $bRepo
     * @param UnAssignRequest $r
     * @return Response
     */
    public function unassignBuilding(int $id, int $bid, BuildingRepository $bRepo, UnAssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $b = $bRepo->findWithoutFail($bid);
        if (empty($b)) {
            return $this->sendError(__('models.post.errors.building_not_found'));
        }

        $p->buildings()->detach($b);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();


        return $this->sendResponse($p, __('general.detached.building'));
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/quarters/{did}",
     *      summary="Assign the provided quarter to the post",
     *      tags={"Listing"},
     *      description="Assign the provided quarter to the post",
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
     *                  ref="#/definitions/Post"
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
     * @param int $qid
     * @param QuarterRepository $qRepo
     * @param AssignRequest $r
     * @return Response
     */
    public function assignQuarter(int $id, int $qid, QuarterRepository $qRepo, AssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $d = $qRepo->findWithoutFail($qid);
        if (empty($d)) {
            return $this->sendError(__('models.post.errors.quarter_not_found'));
        }

        $p->quarters()->sync($d, false);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();


        return $this->sendResponse($p, __('general.attached.quarter'));
    }

    /**
     * @SWG\Delete(
     *      path="/posts/{id}/quarters/{did}",
     *      summary="Unassign the provided quarter to the post",
     *      tags={"Listing"},
     *      description="Unassign the provided quarter to the post",
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
     *                  ref="#/definitions/Post"
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
     * @param int $qid
     * @param QuarterRepository $qRepo
     * @param UnAssignRequest $r
     * @return Response
     */
    public function unassignQuarter(int $id, int $qid, QuarterRepository $qRepo, UnAssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $d = $qRepo->findWithoutFail($qid);
        if (empty($d)) {
            return $this->sendError(__('models.post.errors.building_not_found'));
        }

        $p->quarters()->detach($d);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();


        return $this->sendResponse($p, __('general.detached.quarter'));
    }

    /**
     * @SWG\Get(
     *      path="/posts/{id}/locations",
     *      summary="Get a listing of the post locations.",
     *      tags={"Listing"},
     *      description="Get a listing of the post locations.",
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
     *                  @SWG\Items(ref="#/definitions/Post")
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
     * @return Response
     * @throws \Exception
     */
    public function getLocations(int $id, ViewRequest $request)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $perPage = $request->get('per_page', env('APP_PAGINATE', 10));
        $locations = $this->postRepository->locations($p)->paginate($perPage);
        return $this->sendResponse($locations, 'Locations retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/posts/{id}/providers/{pid}",
     *      summary="Assign the provided service provider to the post",
     *      tags={"Listing"},
     *      description="Assign the provided service provider to the post",
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
     *                  ref="#/definitions/Post"
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
     * @param ServiceProviderRepository $pRepo
     * @param AssignRequest $r
     * @return Response
     */
    public function assignProvider(int $id, int $pid, ServiceProviderRepository $pRepo, AssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $provider = $pRepo->findWithoutFail($pid);
        if (empty($provider)) {
            return $this->sendError(__('models.post.errors.provider_not_found'));
        }

        $p->providers()->sync($provider, false);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
            'providers',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();


        return $this->sendResponse($p, __('general.attached.provider'));
    }

    /**
     * @SWG\Delete(
     *      path="/posts/{id}/providers/{pid}",
     *      summary="Unassign the provided service provider to the post",
     *      tags={"Listing"},
     *      description="Unassign the provided service provider to the post",
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
     *                  ref="#/definitions/Post"
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
     * @param ServiceProviderRepository $pRepo
     * @param UnAssignRequest $r
     * @return mixed
     */
    public function unassignProvider(int $id, int $pid, ServiceProviderRepository $pRepo, UnAssignRequest $r)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }
        $provider = $pRepo->findWithoutFail($pid);
        if (empty($provider)) {
            return $this->sendError(__('models.post.errors.provider_not_found'));
        }

        $p->providers()->detach($provider);
        $p = $this->postRepository->with([
            'media',
            'user.tenant',
            'likesCounter',
            'likes',
            'likes.user',
            'buildings.address.state',
            'buildings.serviceProviders',
            'buildings.media',
            'quarters',
            'providers',
        ])->withCount('allComments')->findWithoutFail($id);
        $p->likers = $p->collectLikers();

        return $this->sendResponse($p, __('general.detached.provider'));
    }

    /**
     * @SWG\Put(
     *      path="/posts/{id}/views",
     *      summary="Increment the view count of the post",
     *      tags={"Listing"},
     *      description="Increment the view count of the post",
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
     *                  ref="#/definitions/Post"
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
     * @return mixed
     */
    public function incrementViews(int $id)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $p->incrementViews(\Auth::id());
        return $this->sendResponse($id, 'Views increased successfully');
    }

    /**
     * @SWG\Get(
     *      path="/posts/{id}/views",
     *      summary="List the view count of the post",
     *      tags={"Listing"},
     *      description="List the view count of the post",
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
     *                  ref="#/definitions/PinboardView"
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
     * @param PostViewTransformer $pvt
     * @param ListViewsRequest $req
     * @return mixed
     */
    public function indexViews(int $id, PostViewTransformer $pvt, ListViewsRequest $req)
    {
        $p = $this->postRepository->findWithoutFail($id);
        if (empty($p)) {
            return $this->sendError(__('models.post.errors.not_found'));
        }

        $perPage = $req->get('per_page', env('APP_PAGINATE', 10));
        $vs = $p->views()->with('user')->paginate($perPage);
        $ret = $pvt->transformPaginator($vs);
        return $this->sendResponse($ret, 'Views retrieved successfully');
    }
}
