<?php

namespace App\Http\Requests\API\Building;

use App\Http\Requests\BaseRequest;
use App\Models\Building;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('edit-building');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Building::$rules;
    }
}
