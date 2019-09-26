<?php

namespace App\Http\Requests\API\UserSetting;

use App\Http\Requests\BaseRequest;

class UpdateLoggedInRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // @TODO ROLE RELATED
        return true;
    }
}

