<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Models\ServiceRequest;
use App\Models\ServiceRequestCategory;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Request\APIRequest;

/**
 * Class CreateRequest
 * @package App\Http\Requests\API\ServiceRequest
 */
class CreateRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if (!$user->can(['post-request_tenant', 'post-request_service', 'post-request'])) {
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
        if ($user->can('post-request_tenant')) {
            return ServiceRequest::$rulesPostTenant;
        }

        $rules = ServiceRequest::$rulesPost;
        $serviceRequestCategories = ServiceRequestCategory::where('has_qualifications', 1)->pluck('id');
        $rules['qualification'] = 'required_if:category_id,'  . $serviceRequestCategories->implode(',') .  '|integer';// todo improve permit only specific integers
        return $rules;
    }
}
