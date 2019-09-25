<?php

namespace App\Http\Requests\API\Quarter;

use App\Http\Requests\BaseRequest;

class BatchAssignManagers extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return $this->can('assign-quarter');
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
        ];
    }
}
