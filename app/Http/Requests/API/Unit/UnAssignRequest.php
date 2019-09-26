<?php

namespace App\Http\Requests\API\Unit;

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
        return $this->can('assign-unit');
    }
}
