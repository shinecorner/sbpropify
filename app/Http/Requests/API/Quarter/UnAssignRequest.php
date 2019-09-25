<?php

namespace App\Http\Requests\API\Quarter;

use InfyOm\Generator\Request\APIRequest;

class UnAssignRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return $this->user()->can('delete-quarter');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
