<?php

namespace App\Http\Requests\API\Request;

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
        return true;
        return $this->can('view-request');
    }

}

