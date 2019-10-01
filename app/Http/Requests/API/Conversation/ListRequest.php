<?php

namespace App\Http\Requests\API\Conversation;

use App\Http\Requests\BaseRequest;

class ListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return $this->can('list-conversation'); // @TODO
    }
}

