<?php

namespace App\Http\Requests\API\Pinboard;

use App\Models\Pinboard;
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
        return Pinboard::where('id', $this->route('pinboard') ?? $this->route('post'))
            ->where('user_id', $u->id)->first();
    }
}
