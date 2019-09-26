<?php

namespace App\Http\Requests\API\Pinboard;

use App\Models\Pinboard;
use App\Http\Requests\BaseRequest;

class ShowRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = \Auth::user();
        if ($u->can('view-pinboard')) {
            return true;
        }
        $p = Pinboard::where('id', $this->route('pinboard'))->first();
        if (!$p) {
            return false;
        }

        if ($p->user_id == $u->id) {
            return true;
        }

        return $p->status == Pinboard::StatusPublished;
    }
}
