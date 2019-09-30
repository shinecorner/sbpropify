<?php

namespace App\Http\Requests\API\InternalNotice;

use App\Http\Requests\BaseRequest;
use App\Models\InternalNotice;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('add-internal_notice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return InternalNotice::$rules;
    }
}
