<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Request\APIRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends APIRequest
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
        $user = Auth::user();
        if ($user->can('edit-request_tenant')) {
            return ServiceRequest::$rulesPutTenant;
        }

        if ($user->can('edit-request_service')) {
            return ServiceRequest::$rulesPutService;
        }
        $putRoles =  ServiceRequest::$rulesPut;
        $putRoles['reminder_user_id'] = Rule::requiredIf(function () {
            return $this->active_reminder == true;
        });
        $putRoles['days_left_due_date'] = $putRoles['reminder_user_id'];

        return $putRoles;
    }
}
