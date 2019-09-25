<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BaseRequest;

class ChangePriorityRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if (!$user->can(['edit-request_tenant', 'edit-request_service', 'edit-request'])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validValues = '|in:' . implode(',', array_keys(ServiceRequest::Priority));

        $rules = [
            'priority' => 'required|integer' . $validValues,
            'internal_priority' => 'integer' . $validValues,
        ];

        return $rules;
    }
}
