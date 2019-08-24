<?php

namespace App\Transformers;

use App\Models\PropertyManager;

/**
 * Class PropertyManagerTransformer.
 *
 * @package namespace App\Transformers;
 */
class PropertyManagerTransformer extends BaseTransformer
{
    /**
     * Transform the Building entity.
     *
     * @param PropertyManager $model
     *
     * @return array
     */
    public function transform(PropertyManager $model)
    {
        $response = [
            'id' => $model->id,
            'property_manager_format' => $model->property_manager_format,
            'description' => $model->description,
            'title' => $model->title,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'profession' => $model->profession,
            'slogan' => $model->slogan,
            'xing_url' => $model->xing_url,
            'linkedin_url' => $model->linkedin_url,
        ];
        $withCount = collect($model->getAttributes())->only([
            'requests_count',
            'requests_received_count',
            'requests_in_processing_count',
            'requests_assigned_count',
            'requests_done_count',
            'requests_reactivated_count',
            'requests_archived_count',
            'solved_requests_count',
            'pending_requests_count',
        ])->all();

        $response = array_merge($response, $withCount);

        if ($model->relationExists('settings')) {
            $response['settings'] = $model->settings;
        }

        if ($model->relationExists('user')) {
            $response['user'] = (new UserTransformer)->transform($model->user);
        }

        if ($model->relationExists('buildings')) {
            $response['buildings'] = (new BuildingTransformer)->transformCollection($model->buildings);
            $response['buildings_count'] = $model->buildings->count();
        }

        if ($model->relationExists('districts')) {
            $response['districts'] = (new DistrictTransformer)->transformCollection($model->districts);
        }

        return $response;
    }
}
