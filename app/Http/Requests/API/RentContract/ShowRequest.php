<?php

namespace App\Http\Requests\API\RentContract;

use InfyOm\Generator\Request\APIRequest;

class ShowRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('view-tenant'); // @TODO add new rule list-rent_contract
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