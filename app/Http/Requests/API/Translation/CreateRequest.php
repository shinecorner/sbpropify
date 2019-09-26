<?php

namespace App\Http\Requests\API\Translation;

use App\Http\Requests\BaseRequest;
use App\Models\Translation;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('add-translation');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Translation::$rules;
    }
}
