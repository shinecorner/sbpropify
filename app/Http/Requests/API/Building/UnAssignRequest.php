<?php

namespace App\Http\Requests\API\Building;

use App\Http\Requests\BaseRequest;

class UnAssignRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // @TODO ROLE RELATED is need unassign-building like add-building, deleted building
        return $this->user()->can('assign-building');
    }
}
