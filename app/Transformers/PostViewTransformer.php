<?php

namespace App\Transformers;

use App\Models\PinboardView;

/**
 * Class PostViewTransformer.
 *
 * @package namespace App\Transformers;
 */
class PostViewTransformer extends BaseTransformer
{
    protected $defaultIncludes = [];

    /**
     * Transform the PinboardView entity.
     *
     * @param \App\Models\PinboardView $model
     *
     * @return array
     */
    public function transform(PinboardView $model)
    {
        $ut = new UserTransformer();
        $ret = [
            'id' => $model->id,
            'views' => $model->views,
            'created_at' => $model->created_at->toDateTimeString(),
            'updated_at' => $model->updated_at->toDateTimeString(),
            'tenant_id' => $model->tenant_id,
        ];

        if ($model->relationExists('user')) {
            $ret['user'] = $ut->transform($model->user);
        }

        return $ret;
    }
}
