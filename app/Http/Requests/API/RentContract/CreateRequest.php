<?php

namespace App\Http\Requests\API\RentContract;

use App\Models\RentContract;
use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('add-tenant'); // @TODO use correct permission
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return RentContract::$rules;
    }
}
