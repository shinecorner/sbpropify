<?php

namespace App\Transformers;

use App\Models\Post;

/**
 * Class PostTransformer.
 *
 * @package namespace App\Transformers;
 */
class PostTransformer extends BaseTransformer
{
    protected $defaultIncludes = [];

    /**
     * Transform the Post entity.
     *
     * @param \App\Models\Post $model
     *
     * @return array
     */
    public function transform(Post $model)
    {
        $ut = new UserTransformer();
        $tt = new TenantTransformer();



        $ret = [
            'id' => $model->id,
            'type' => $model->type,
            'sub_type' => $model->sub_type,
            'is_execution_time' => (bool)$model->is_execution_time,
            'status' => $model->status,
            'visibility' => $model->visibility,
            'category_image' => (bool) $model->category_image,
            'category' => $model->category,
            'content' => $model->content,
            'title' => $model->title,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString(),
            'published_at' => $model->published_at ? $model->published_at->toDateTimeString() : null,
            'user_id' => $model->user_id,
            'user' => $ut->transform($model->user),
            'tenant' => $model->user->tenant ? $tt->transform($model->user->tenant) : null,
            'liked' => $model->liked,
            'likes_count' => $model->likesCount,
            'comments_count' => $model->all_comments_count,
            'pinned' => $model->pinned,
            'pinned_to' => $model->pinned_to ? $model->pinned_to->toDateTimeString() : null,
            'execution_start' => $this->formatExecutionTime($model, 'execution_start'),
            'execution_end' => $this->formatExecutionTime($model, 'execution_end'),
            'notify_email' => $model->notify_email,
        ];

        if (key_exists('views_count', $model->getAttributes())) {
            $ret['views_count'] = $model->views_count;
        }

        if ($model->relationExists('buildings')) {
            $ret['buildings'] = (new BuildingTransformer)->transformCollection($model->buildings);
        }
        if ($model->relationExists('quarters')) {
            $ret['quarters'] = (new QuarterTransformer)->transformCollection($model->quarters);
        }
        if ($model->relationExists('providers')) {
            $ret['providers'] = (new ServiceProviderTransformer)->transformCollection($model->providers);
        }
        if ($model->relationExists('likes')) {
            $ret['likes'] = (new LikeTransformer)->transformCollection($model->likes);
        }
        if ($model->relationExists('media')) {
            $ret['media'] = (new MediaTransformer)->transformCollection($model->media);
        }
        if ($model->relationExists('views')) {
            $ret['views'] = $model->views->sum('views');
        }

        return $ret;
    }

    protected function formatExecutionTime($model, $col)
    {
        $value = $model->{$col};
        if ($value) {
            return $model->is_execution_time ? $value->toDateTimeString()  : $value->format('Y-m-d');
        }
        return null;
    }
}
