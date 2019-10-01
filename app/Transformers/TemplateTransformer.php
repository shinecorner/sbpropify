<?php

namespace App\Transformers;

use App\Models\Settings;
use App\Models\Template;

/**
 * Class TemplateTransformer.
 *
 * @package namespace App\Transformers;
 */
class TemplateTransformer extends BaseTransformer
{
    /**
     * Transform the Template entity.
     *
     * @param Template $model
     *
     * @return array
     */
    public function transform(Template $model)
    {
        $response = [
            'id' => $model->id,
            'name' => $model->name,
            'subject' => $model->subject,
            'body' => $model->body,
            'category_id' => $model->category_id,
            'type' => $model->type,
            'system' => $model->system
        ];

        if ($model->relationExists('category')) {
            $response['category'] = (new TemplateCategoryTransformer)->transform($model->category);
        }

        $response['translations'] = [];
        if (! $model->relationExists('translations')) {
            return $response;
        }

        $settings = (new Settings())->first();
        $response['translations'][$settings->language]['subject'] = $response['subject'];
        $response['translations'][$settings->language]['body'] = $response['body'];

        foreach ($model->translations as $tr) {
            if (!isset($response['translations'][$tr->language])) {
                $response['translations'][$tr->language] = [];
            }
            $response['translations'][$tr->language][$tr->name] = $tr->value;
        }

        return $response;
    }
}
