<?php

namespace App\Http\Requests\API\Comment;

use App\Http\Requests\BaseRequest;
use App\Models\Post;
use App\Models\Conversation;
use InfyOm\Generator\Request\APIRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Validation\Rule;

class ChildrenListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // users can only see comments from own conversations
        if (Relation::$morphMap[$this->commentable] == Conversation::class) {
            return Conversation::where('id', $this->id)->ofLoggedInUser()->exists();
        }

        // and comments from all other models
        return true;
    }
}
