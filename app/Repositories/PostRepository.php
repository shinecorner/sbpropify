<?php

namespace App\Repositories;

use App\Models\Building;
use App\Models\Model;
use App\Models\Quarter;
use App\Models\Post;
use App\Models\RentContract;
use App\Models\Tenant;
use App\Models\RealEstate;
use App\Models\User;
use App\Notifications\NewTenantInNeighbour;
use App\Notifications\NewTenantPost;
use App\Notifications\PinnedPostPublished;
use App\Notifications\PostPublished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class PostRepository
 * @package App\Repositories
 * @version February 11, 2019, 6:22 pm UTC
 *
 * @method Post findWithoutFail($id, $columns = ['*'])
 * @method Post find($id, $columns = ['*'])
 * @method Post first($columns = ['*'])
*/
class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content' => 'like',
    ];

    /**
     * @var array
     */
    protected $mimeToExtension = [
        "image/jpeg" =>  "jpg",
        "image/png" =>  "png",
    ];


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    /**
     * @param array $atts
     * @return Post|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $atts)
    {
        $atts['building_ids'] = $atts['building_ids'] ?? [];
        $atts['quarter_ids'] = $atts['quarter_ids'] ?? [];
        $u = \Auth::user();
        if ($u->can('post-post') && !($u->can('post-located-post'))) {
            if ($u->tenant()->exists()) {
                $rentContracts = $u->tenant->active_rent_contracts_with_building()->get(['building_id']);
                if ($rentContracts->isEmpty()) {
                    throw new \Exception("Your tenant account does not have any active rent contract");
                }

                $rentContracts->load('building:id,quarter_id');
                $atts['building_ids'] = $rentContracts->pluck('building_id')->unique()->toArray();
                $quarterIds = $rentContracts->where('building.quarter_id', '!=', null)->pluck('building.quarter_id');
                $atts['quarter_ids'] = $quarterIds->unique()->toArray();
            }
        }

        if (isset($atts['category_image'])) {
            $atts['category_image'] = ($atts['category_image'] == 'true') ? 1 : 0;
        } else {
            $atts['category_image'] = 0;
        }

        $atts = $this->fixBollInt($atts, 'is_execution_time', 1);

        if (! $atts['needs_approval']) {
            // @TODO correct this things
            $atts['status'] = Post::StatusPublished;
        }

        if (Post::StatusPublished == $atts['status']) {
            $atts['published_at'] = now();
        }

        $model = parent::create($atts);
        if (!empty($atts['quarter_ids'])) {
            $model->quarters()->sync($atts['quarter_ids']);
        }

        if (!empty($atts['building_ids'])) {
            $model->buildings()->sync($atts['building_ids']);
        }

        $notificationsData = collect();
        if (Post::StatusPublished == $atts['status']) {
            $notificationsData = $this->notify($model);
        }
        $adminNotificationsData = $this->notifyAdminNewTenantPosts($model);
        $notificationsData = $notificationsData->merge($adminNotificationsData);
        $this->saveNotificationAuditsAndLogs($model, $notificationsData);
//        $this->notifyAdminActions($model);
        return $model;
    }

    protected function saveNotificationAuditsAndLogs(Post $post, $notificationsData)
    {
        $pinnedPostPublished = get_morph_type_of(PinnedPostPublished::class);
        $pinnedPostPublishedUsers = $notificationsData[$pinnedPostPublished] ?? collect();
        if ($pinnedPostPublishedUsers->isNotEmpty()) {
            $post->pinned_email_receptionists()->create([
                'tenant_ids' => $pinnedPostPublishedUsers->pluck('tenant.id'),
                'failed_tenant_ids' => []
            ]);
        }

        $post->addDataInAudit('notifications', $notificationsData);
    }


    /**
     * @param int $id
     * @param $status
     * @param $publishedAt
     * @return Post|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function setStatus(int $id, $status, $publishedAt)
    {
        $post = $this->find($id);
        return $this->setStatusExisting($post, $status, $publishedAt);
    }

    /**
     * @param Post $post
     * @param $status
     * @param $publishedAt
     * @return Post|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function setStatusExisting(Post $post, $status, $publishedAt)
    {
        if ($post->status == $status) {
            return $post;
        }

        return $this->updateExisting($post, ['status' => $status]);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return Model|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(array $attributes, $id)
    {
        $model = $this->model->findOrFail($id);
        return $this->updateExisting($model, $attributes);
    }

    /**
     * @param Model $model
     * @param $attributes
     * @return Model|mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function updateExisting(Model $model, $attributes)
    {
        $attributes = $this->fixBollInt($attributes, 'is_execution_time', 1);
        $status= $attributes['status'] ?? null;
        if (Post::StatusPublished == $status) {
            $attributes['published_at'] = now();
        }
        $model = parent::updateExisting($model, $attributes);

        if (Post::StatusPublished == $status) {
            $this->notify($model);
        }

        return $model;
    }

    /**
     * @param Post $post
     * @return \Illuminate\Support\Collection
     */
    public function notify(Post $post)
    {
        if (!$post->notify_email) {
            return collect();
        }

        $usersToNotify = $this->getNotifiedTenantUsers($post);

        $pinnedPostPublished = get_morph_type_of(PinnedPostPublished::class);
        $postPublished = get_morph_type_of(PostPublished::class);
        $postNewTenantNeighbor = get_morph_type_of(NewTenantInNeighbour::class);
        $notificationsData = collect([
            $pinnedPostPublished => collect(),
            $postPublished => collect(),
            $postNewTenantNeighbor => collect(),
        ]);

        if ($usersToNotify->isEmpty()) {
            return $notificationsData;
        }

        $usersToNotify->load('settings:user_id,admin_notification,news_notification', 'tenant:id,user_id,first_name,last_name');
        $i = 0;
        foreach ($usersToNotify as $u) {
            $delay = $i++ * env("DELAY_BETWEEN_EMAILS", 10);
            $u->redirect = '/news';
            if ($u->settings && $u->settings->admin_notification && $post->pinned) {
                $notificationsData[$pinnedPostPublished]->push($u);
                $u->notify((new PinnedPostPublished($post))
                    ->delay(now()->addSeconds($delay)));
                continue;
            }
            if ($u->settings && $u->settings->news_notification && ! $post->pinned) {
                if ($post->type == Post::TypePost) {
                    $notificationsData[$postPublished]->push($u);
                    $u->notify(new PostPublished($post));
                }
                if ($post->type == Post::TypeNewNeighbour) {
                    $notificationsData[$postNewTenantNeighbor]->push($u);
                    $u->notify((new NewTenantInNeighbour($post))->delay($post->published_at));
                }
            }
        }

        return $notificationsData;
    }

    /**
     * @param Post $post
     * @return Collection
     */
    protected function getNotifiedTenantUsers(Post $post)
    {
        if ($post->visibility == Post::VisibilityAll) {
            return User::whereHas('tenant', function ($q) {
                    $q->whereNull('tenants.deleted_at');
                })
                ->where('id', '!=', $post->user_id)
                ->get();
        }

        $quarterIds = $buildingIds = [];
        if ($post->visibility == Post::VisibilityQuarter || $post->pinned) {
            $quarterIds = $post->quarters()->pluck('id')->toArray();
        }

        if ($post->visibility == Post::VisibilityAddress  || $post->pinned) {
            $buildingIds = $post->buildings()->pluck('id')->toArray();
        }
        if (empty($quarterIds) && empty($buildingIds)) {
            return $post->newCollection();
        }

        return User::whereHas('tenant', function ($q) use ($quarterIds, $buildingIds) {
            $q->whereNull('tenants.deleted_at')
                ->where('tenants.status', Tenant::StatusActive)
                ->whereHas('rent_contracts', function ($q) use ($quarterIds, $buildingIds) {

                    $q->where('status', RentContract::StatusActive)
                        ->when(
                            ! empty($quarterIds) && !empty($buildingIds),
                            function ($q)  use ($quarterIds, $buildingIds) {
                                $q->whereHas('building', function ($q) use ($quarterIds, $buildingIds) {
                                    $q->where(function ($q) use ($quarterIds, $buildingIds) {
                                        $q->whereIn('id', $buildingIds)->orWhereIn('quarter_id', $quarterIds);
                                    })->whereNull('buildings.deleted_at');
                                });
                            },
                            function ($q) use ($quarterIds, $buildingIds) {
                                $q->when(
                                    !empty($quarterIds),
                                    function ($q) use ($quarterIds) {
                                        $q->whereHas('building', function ($q) use ($quarterIds) {
                                            $q  ->whereIn('quarter_id', $quarterIds)
                                                ->whereNull('buildings.deleted_at');
                                        });
                                    },
                                    function ($q) use ($buildingIds) {
                                        $q->whereIn('building_id', $buildingIds);
                                    }
                                );
                            }
                        );
                });
        })->get();
    }

    /**
     * @param Post $post
     */
    public function notifyAdminActions(Post $post)
    {
        if (! Auth::user()->hasRole('super_admin')) {
            return;
        }
        // @TODO
    }

    public function notifyAdminNewTenantPosts(Post $post)
    {
        $newTenantPost = get_morph_type_of(NewTenantPost::class);
        if (empty($post->user->tenant)) {
            return collect([$newTenantPost => collect()]);
        }

        $re = RealEstate::firstOrFail();
        $admins = User::whereIn('id', $re->news_receiver_ids)->get();
        $i = 0;
        foreach ($admins as $admin) {
            $delay = $i++ * env("DELAY_BETWEEN_EMAILS", 10);
            $admin->redirect = '/admin/posts';

            $notif = (new NewTenantPost($post, $admin))->delay(now()->addSeconds($delay));
            $admin->notify($notif);
        }

        return collect([$newTenantPost => $admins]);
    }

    /**
     * @param Tenant $tenant
     * @return Post|bool|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function newTenantPost(Tenant $tenant)
    {
        if ($tenant->homeless()) {
            return false;
        }

        $post = $this->create([
            'visibility' => Post::VisibilityAddress,
            'status' => Post::StatusNew,
            'type' => Post::TypeNewNeighbour,
            'content' => "New neighbour",
            'user_id' => $tenant->user->id,
            'building_ids' => [$tenant->building->id],
            'needs_approval' => false,
            'notify_email' => true,
        ]);

        $publishStart = $tenant->rent_start ?? Carbon::now();
        if ($publishStart->isBefore(Carbon::now())) {
            $publishStart = Carbon::now();
        }

        $this->setStatusExisting($post, Post::StatusPublished, $publishStart);
        return $post;
    }

    /**
     * @param RentContract $rentContract
     * @return Post|bool|mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function newRentContractPost(RentContract $rentContract)
    {
        if (empty($rentContract->building_id)) {
            return false;
        }

        $post = $this->create([
            'visibility' => Post::VisibilityAddress,
            'status' => Post::StatusNew,
            'type' => Post::TypeNewNeighbour,
            'content' => "New neighbour",
            'user_id' => $rentContract->tenant->user->id,
            'building_ids' => [$rentContract->building_id],
            'needs_approval' => false,
            'notify_email' => true,
        ]);

        $publishStart = $rentContract->start_date ?? Carbon::now();
        if ($publishStart->isBefore(Carbon::now())) {
            $publishStart = Carbon::now();
        }

        $this->setStatusExisting($post, Post::StatusPublished, $publishStart);
        return $post;
    }

    /**
     * @param Post $p
     * @return mixed
     */
    public function locations(Post $p)
    {
        // Cannot use $p->buildings() and $p->quarters() because of a bug
        // related to different number of columns in union
        $pbs = Building::select(\DB::raw('id, name, "building" as type'))
            ->join('building_post', 'building_post.building_id', '=', 'id')
            ->where('building_post.post_id', $p->id);
        $pds = Quarter::select(\DB::raw('id, name, "quarter" as type'))
            ->join('quarter_post', 'quarter_post.quarter_id', '=', 'id')
            ->where('quarter_post.post_id', $p->id);

        return $pbs->union($pds);
    }
}
