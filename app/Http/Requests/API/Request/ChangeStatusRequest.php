<?php

namespace App\Http\Requests\API\Request;

use App\Models\Request;
use App\Http\Requests\BaseRequest;

class ChangeStatusRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('edit-request');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validValues = '|in:' . implode(',', array_keys(Request::Status));

        $rules = [
            'status' => 'required|integer' . $validValues,
        ];

        return $rules;
    }
}
