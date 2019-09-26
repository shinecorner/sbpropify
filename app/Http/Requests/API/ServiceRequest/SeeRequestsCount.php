<?php

namespace App\Http\Requests\API\ServiceRequest;

use App\Http\Requests\BaseRequest;

class SeeRequestsCount extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->tenant()->exists()) {
            return false;
        }
        
        return true;
    }
}

