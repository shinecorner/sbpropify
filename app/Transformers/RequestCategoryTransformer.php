<?php

namespace App\Transformers;

use App\Models\RequestCategory;

/**
 * Class RequestCategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class RequestCategoryTransformer extends BaseTransformer
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
            'name_en' => $model->name,
            'name_de' => $model->name_de,
            'name_fr' => $model->name_fr,
            'name_it' => $model->name_it,
            'description' => $model->description,
            'has_qualifications' => $model->has_qualifications,
            'acquisition' => $model->acquisition,
            'location' => $model->location,
            'room' => $model->room,
        ];

        // @TODO check and use ->relationExists
        if ($model->categories) {
            $response['categories'] = $this->transformCollection($model->categories);
        }

        return $response;
    }
}
