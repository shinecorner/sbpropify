<?php

namespace App\Http\Requests\API\User;

use App\Models\User;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return User::$rulesUpdate;
    }
}
