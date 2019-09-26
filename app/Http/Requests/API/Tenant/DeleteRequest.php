<?php

namespace App\Http\Requests\API\Tenant;

use App\Models\Tenant;
use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('delete-tenant');
    }
}
