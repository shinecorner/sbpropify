<?php

namespace App\Transformers;

use App\Models\TemplateCategory;

/**
 * Class TemplateCategoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class TemplateCategoryTransformer extends BaseTransformer
{
    /**
     * Transform the RequestCategory entity.
     *
     * @param \App\Models\TemplateCategory $model
     *
     * @return array
     */
    public function transform(TemplateCategory $model)
    {
        $tags = is_array($model->tag_map) ? array_keys($model->tag_map) : [];
        $tags[] = 'settingsCompany';
        $tags[] = 'primaryColor';
        $response = [
            'id' => $model->id,
            'parent_id' => $model->parent_id,
            'name' => $model->name,
            'description' => $model->description,
            'tags' => $tags
        ];

        // @TODO check lazy loading use also relationExists
        if ($model->parent_id == 0 || !$model->parentCategory) {
            $response['categories'] = $this->transformCollection($model->categories);
            return $response;
        }

        return $response;
    }
}
