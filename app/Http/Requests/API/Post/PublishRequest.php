<?php

namespace App\Http\Requests\API\Post;

use App\Models\Post;
use App\Http\Requests\BaseRequest;

class PublishRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('publish-post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Post::publishRules();
    }
}
