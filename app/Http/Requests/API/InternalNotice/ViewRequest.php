<?php

namespace App\Http\Requests\API\InternalNotice;

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
        //TODO ROLE RELATED is need create view-internal_notice
        return true;
    }
}
