<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Http\Requests\BaseRequest;

class NotifyProviderRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('notify-provider');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_provider_id' => 'required|exists:service_providers,id',
            'property_manager_id' => 'nullable|exists:property_managers,id',
            'title' => 'string|required',
            'body' => 'string|required',
            'to' => 'nullable|email',
            'cc.*' => 'email',
            'bcc.*' => 'email',
        ];
    }
}
