<?php

namespace App\Transformers;

use App\Models\QuarterAssignee;

/**
 * Class QuarterAssigneeTransformer
 * @package App\Transformers
 */
class QuarterAssigneeTransformer extends BaseTransformer
{
    /**
     * Transform the ServiceProvider entity.
     *
     * @param QuarterAssignee $model
     *
     * @return array
     */
    public function transform(QuarterAssignee $model)
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
