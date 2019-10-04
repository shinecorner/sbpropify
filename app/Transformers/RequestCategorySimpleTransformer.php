<?php

namespace App\Transformers;

use App\Models\RequestCategory;

/**
 * Class RequestCategorySimpleTransformer.
 *
 * @package namespace App\Transformers;
 */
class RequestCategorySimpleTransformer extends BaseTransformer
{
    /**
     * Transform the RequestCategory entity.
     *
     * @param \App\Models\RequestCategory $model
     *
     * @return array
     */
    public function transform(RequestCategory $model)
    {
        $response = [
            'id' => $model->id,
            'parent_id' => $model->parent_id,
            'name' => $model->name,
            'description' => $model->description,
            'acquisition' => $model->acquisition,
        ];

        // @TODO check and use ->relationExists
        if ($model->parent_id > 0 && $model->parentCategory) {
            $response['parentCategory'] = $this->transform($model->parentCategory);
        }

        return $response;
    }
}
