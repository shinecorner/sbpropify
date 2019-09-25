<?php

namespace App\Http\Requests\API\PropertyManager;

use App\Http\Requests\BaseRequest;

class AssigneeListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('assign-property_manager');
    }
}
