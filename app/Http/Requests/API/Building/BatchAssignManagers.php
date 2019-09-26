<?php

namespace App\Http\Requests\API\Building;

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
        return $this->can('assign-building');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'managerIds' => 'required_without:managersIds|array',
            'managersIds' => 'array', // @TODO delete
            'managerIds.*' => 'integer',
            'managersIds.*' => 'integer',
        ];
    }
}
