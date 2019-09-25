<?php

namespace App\Http\Requests\API\InternalNotice;

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
        //TODO ROLE RELATED is need create list-internal_notice
        return true;
    }
}
