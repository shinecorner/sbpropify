<?php

namespace App\Http\Requests\API\Quarter;

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
        return $this->can('assign-quarter');
    }
}
