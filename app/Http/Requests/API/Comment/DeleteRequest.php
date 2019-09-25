<?php

namespace App\Http\Requests\API\Comment;

use App\Http\Requests\BaseRequest;
use App\Models\Comment;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO ROLE RELATED is need create delete-comment like other
        if ($this->can('edit-comment')) {
            return true;
        }
        return Comment::where('id', $this->route('id'))
            ->where('user_id', \Auth::id())->exists();
    }
}
