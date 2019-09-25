<?php

namespace App\Http\Requests\API\Building;

use App\Http\Requests\BaseRequest;

class DeleteAssigneeRequest extends BaseRequest
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
}
