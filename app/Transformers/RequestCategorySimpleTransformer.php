<?php

namespace App\Transformers;

use App\Models\ServiceRequestCategory;

/**
 * Class RequestCategorySimpleTransformer.
 *
 * @package namespace App\Transformers;
 */
class RequestCategorySimpleTransformer extends BaseTransformer
{
    /**
     * Transform the ServiceRequestCategory entity.
     *
     * @param \App\Models\ServiceRequestCategory $model
     *
     * @return array
     */
    public function transform(ServiceRequestCategory $model)
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
