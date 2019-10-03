<?php

namespace App\Transformers;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssignee;

/**
 * Class RequestTransformer
 *
 * @package namespace App\Transformers;
 */
class RequestAssigneeTransformer extends BaseTransformer
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
            'edit_id' => $model->assignee_id,
            'type' => $model->assignee_type,
            'email' => $model->related ? $model->related->email : 'incorrect relation',
            'name' => $model->related ? $model->related->name : 'incorrect relation',
            'avatar' => $model->related ? $model->related->avatar : 'incorrect relation'
        ];

        return $response;
    }
}
