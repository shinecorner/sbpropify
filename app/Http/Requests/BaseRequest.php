<?php

namespace App\Http\Requests;

use InfyOm\Generator\Request\APIRequest;

class BaseRequest extends APIRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * @param $permission
     * @return mixed
     */
    protected function can($permission)
    {
        return $this->user()->can($permission);
    }
}
