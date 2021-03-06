<?php

namespace App\Http\Requests\API\Conversation;

use App\Http\Requests\BaseRequest;
use App\Models\Comment;
use App\Models\Conversation;

class CommentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Conversation::ofLoggedInUser()
            ->where('id', $this->route('id'))->exists();
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

