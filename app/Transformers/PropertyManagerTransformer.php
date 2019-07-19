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

        if ($model->relationExists('user')) {
            $response['requests_received_count'] = $model->user->requests_received_count ?? 0;
            $response['requests_in_processing_count'] = $model->user->requests_in_processing_count ?? 0;
            $response['requests_assigned_count'] = $model->user->requests_assigned_count ?? 0;
            $response['requests_done_count'] = $model->user->requests_done_count ?? 0;
            $response['requests_reactivated_count'] = $model->user->requests_reactivated_count ?? 0;
            $response['requests_archived_count'] = $model->user->requests_archived_count ?? 0;
            $response['user'] = (new UserTransformer)->transform($model->user);
        }

        if ($model->relationExists('buildings')) {
            $response['buildings'] = (new BuildingTransformer)->transformCollection($model->buildings);
        }

        if ($model->relationExists('districts')) {
            $response['districts'] = (new DistrictTransformer)->transformCollection($model->districts);
        }

        return $response;
    }
}
