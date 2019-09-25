<?php

namespace App\Http\Requests\API\CleanifyRequest;

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
        return $this->user()->can('add-cleanify_request');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ];
    }
}
