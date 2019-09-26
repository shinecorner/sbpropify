<?php

namespace App\Http\Requests\API\Comment;

use App\Http\Requests\BaseRequest;
use App\Models\Comment;

class CreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('add-comment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Comment::rules();
    }
}
