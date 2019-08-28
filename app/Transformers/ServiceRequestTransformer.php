<?php

namespace App\Transformers;

use App\Models\ServiceRequest;

/**
 * Class ServiceRequestTransformer
 *
 * @package namespace App\Transformers;
 */
class ServiceRequestTransformer extends BaseTransformer
{
    /**
     * Transform the ServiceProvider entity.
     *
     * @param ServiceRequest $model
     *
     * @return array
     */
    public function transform(ServiceRequest $model)
    {
        $response = [
            'id' => $model->id,
            'service_request_format' => $model->service_request_format,
            'title' => $model->title,
            'description' => $model->description,
            'status' => $model->status,
            'priority' => $model->priority,
            'internal_priority' => $model->internal_priority,
            'qualification' => $model->qualification,
            'is_public' => $model->is_public,
            'room' => $model->room,
            'capture_phase' => $model->capture_phase,
            'component' => $model->component,
            'payer' => $model->payer,
            'location' => $model->location,
            'created_at' => $model->created_at->format('Y-m-d'),
            'created_by' => $model->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $model->updated_at->format('d.m.Y'),
            'visibility' => $model->visibility,
        ];

        if ($model->due_date) {
            $response['due_date'] = $model->due_date->format('d.m.Y');
        }

        if ($model->solved_date) {
            $response['solved_date'] = $model->solved_date->format('Y-m-d');
        }

        $assignedUsers = $model->newCollection();
        if ($model->relationExists('providers')) {
            $assignedUsers = $assignedUsers->merge($model->providers->pluck('user'));
            $response['providers'] = (new ServiceProviderTransformer)->transformCollection($model->providers);
            $response['service_providers'] = (new ServiceProviderTransformer)->transformCollection($model->providers);
        }

        if ($model->relationExists('managers')) {
            $usersCollection = $model->newCollection($model->managers->pluck('user')->all());
            $assignedUsers = $assignedUsers->merge($usersCollection);

            $response['property_managers'] = (new PropertyManagerTransformer())->transformCollection($model->managers);
            $response['assignees'] = $response['property_managers']; // @TODO delete
        }

        if ($assignedUsers->count()) {
            $response['assignedUsers'] = (new UserTransformer)->transformCollection($assignedUsers);
        } else {
            $response['assignedUsers'] = [];
        }


        if ($model->relationExists('category')) {
            $response['category'] = (new ServiceRequestCategorySimpleTransformer)->transform($model->category);
        }

        if ($model->relationExists('tenant')) {
            $response['tenant'] = (new TenantTransformer)->transform($model->tenant);
        }

        if ($model->relationExists('comments')) {
            $response['comments'] = (new CommentTransformer)->transformCollection($model->comments);
        }

        $response['media'] = [];
        if ($model->relationExists('media')) {
            $response['media'] = (new MediaTransformer)->transformCollection($model->media);
        }

        return $response;
    }
}
