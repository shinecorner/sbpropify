<?php

namespace App\Transformers;

use App\Models\Like;


/**
 * Class LikeTransformer.
 *
 * @package namespace App\Transformers;
 */
class LikeTransformer extends BaseTransformer
{
    /**
     * Transform the Like entity.
     *
     * @param \App\Models\Like $model
     *
     * @return array
     */
    public function transform(Like $model)
    {
        return (new UserTransformer())->transform($model->user);
    }
}
