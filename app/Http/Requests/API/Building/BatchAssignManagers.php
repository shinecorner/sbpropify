<?php

namespace App\Http\Requests\API\Building;

use InfyOm\Generator\Request\APIRequest;

class BatchAssignManagers extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('assign-building');
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
