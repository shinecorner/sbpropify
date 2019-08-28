<?php

namespace App\Http\Requests\API\Tag;

use App\Models\Tag;
use InfyOm\Generator\Request\APIRequest;

class CreateRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // @TODO
        return $this->user()->can('tag-district');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Tag::$rules;
    }
}
