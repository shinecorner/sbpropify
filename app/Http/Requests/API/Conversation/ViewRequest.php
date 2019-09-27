<?php

namespace App\Http\Requests\API\Conversation;

use App\Http\Requests\BaseRequest;

class ViewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO ROLE RELATED is need create view-conversation like other
        return true;
    }
}

