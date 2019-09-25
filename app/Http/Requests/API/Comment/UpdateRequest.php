<?php

namespace App\Http\Requests\API\Comment;

use App\Http\Requests\BaseRequest;
use App\Models\Comment;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->can('edit-comment')) {
            return true;
        }
        $comm = Comment::where('id', $this->route('id'))
            ->where('user_id', \Auth::id())->first();
        if (empty($comm)) {
            return false;
        }

        // cannot edit deleted comments
        return $comm->comment != "";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['comment' => 'required|string'];
    }
}
