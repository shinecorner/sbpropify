<?php

namespace App\Http\Requests\API\PropertyManager;

use App\Http\Requests\BaseRequest;

class BatchDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('delete-property_manager');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'managerIds' => 'required|array',
            'managerIds.*' => 'integer',
            'assignee' => 'sometimes|integer',
        ];
    }
}
