<?php

namespace App\Http\Requests\API\Media;

use InfyOm\Generator\Request\APIRequest;

/**
 * Class RentContractDeleteRequest
 * @package App\Http\Requests\API\Media
 */
class RentContractDeleteRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('edit-tenant'); // @TODO correct permission
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
