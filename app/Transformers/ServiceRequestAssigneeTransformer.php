<?php

namespace App\Transformers;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssignee;

/**
 * Class ServiceRequestTransformer
 *
 * @package namespace App\Transformers;
 */
class ServiceRequestAssigneeTransformer extends BaseTransformer
{
    /**
     * Transform the ServiceProvider entity.
     *
     * @param ServiceRequest $model
     *
     * @return array
     */
    public function transform(ServiceRequestAssignee $model)
    {
        $response = [
            'id' => $model->id,
            'item_id' => $model->assignee_id,
            'edit_id' => $model->assignee_id,
            'type' => $model->assignee_type,
            'email' => $model->related->email ?? 'incorrect email',
            'name' => $model->related->name ?? 'incorrect relation'
        ];

        return $response;
    }
}
