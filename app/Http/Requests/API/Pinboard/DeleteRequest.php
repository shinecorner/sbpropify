<?php

namespace App\Http\Requests\API\Pinboard;

use App\Models\Post;
use App\Http\Requests\BaseRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = \Auth::user();
        if ($u->can('delete-pinboard')) {
            return true;
        }
        return Post::where('id', $this->route('pinboard') ?? $this->route('post'))
            ->where('user_id', $u->id)->first();
    }
}
