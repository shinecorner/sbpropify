<?php

namespace App\Http\Requests\API\TenantRentContract;

use App\Models\Tenant;
use InfyOm\Generator\Request\APIRequest;

class DeleteRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete-tenant'); // @TODO add new rule list-tenant_rent_contract
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
