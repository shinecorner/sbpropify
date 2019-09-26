<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Request\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('delete-request');
    }
}
