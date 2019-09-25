<?php

namespace App\Transformers;

use Illuminate\Notifications\DatabaseNotification;

/**
 * Class NotificationTransformer.
 *
 * @package namespace App\Transformers;
 */
class NotificationTransformer extends BaseTransformer
{
    /**
     * Transform the Notification entity.
     *
     * @param \Illuminate\Notifications\DatabaseNotification $model
     *
     * @return array
     */
    public function transform(DatabaseNotification $model)
    {
        $response = [
            'id' => $model->id,
            'read_at' => $model->read_at ? $model->read_at->toDateTimeString() : null,
            'created_at' => $model->created_at->toDateTimeString(),
            'data' => $model->data,
            'type' => snake_case(class_basename($model->type)),
        ];


        if (key_exists('user', $model->relationsToArray())) {
            $response['avatar'] = $model->user->avatar;
        }
        return $response;
    }
}
