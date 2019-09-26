<?php

namespace App\Http\Requests\API\Media;

use App\Models\Pinboard;
use App\Http\Requests\BaseRequest;

class PostDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = \Auth::user();
        if ($u->can('edit-post')) {
            return true;
        }
        $p = Pinboard::where('id', $this->route('id'))
            ->where('user_id', $u->id)->first();
        if (!$p) {
            return false;
        }

        return $p->status == Pinboard::StatusNew;
    }
}
