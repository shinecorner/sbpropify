<?php

namespace App\Http\Requests\API\Comment;

use App\Http\Requests\BaseRequest;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Validation\Rule;

class ListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // users can only see comments from own conversations
        if (empty(Relation::$morphMap[$this->commentable])) {
            return false;
        }

        if (Relation::$morphMap[$this->commentable] == Conversation::class) {
            return Conversation::where('conversationable_id', $this->id)->where('conversationable_type', $this->commentable)
                ->ofLoggedInUser()
                ->exists();
        }

        // and comments from all other models
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'commentable' => [
                'required',
                'string',
                Rule::in(array_keys(Relation::$morphMap)),
            ],
        ];
    }
}
