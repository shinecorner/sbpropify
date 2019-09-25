<?php

namespace App\Http\Requests\API\Tenant;

use App\Models\Tenant;
use InfyOm\Generator\Request\APIRequest;

class UpdateLoggedInRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Tenant::$rules;
    }
}
