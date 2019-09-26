<?php

namespace App\Http\Requests\API\Tag;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('edit-tag');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * @var $request Request
         */
        $request = app('request');
        $tagId = $request->route('tag');
        $rules = [
            'name' => [
                'required',
                'string',
                Rule::unique('tags')->ignore($tagId),
            ]
        ]; // @TODO make it more general way
        return $rules;
    }
}
