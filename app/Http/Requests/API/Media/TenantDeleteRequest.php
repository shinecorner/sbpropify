<?php

namespace App\Http\Requests\API\Media;

use App\Models\Tenant;
use App\Http\Requests\BaseRequest;

class TenantDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // @TODO ROLE RELATED
        return $this->can('edit-tenant');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
