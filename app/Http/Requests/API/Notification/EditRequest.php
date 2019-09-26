<?php

namespace App\Http\Requests\API\Notification;

use App\Http\Requests\BaseRequest;

class EditRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
