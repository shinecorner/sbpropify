<?php

namespace App\Http\Requests\API\Media;

use App\Models\Listing;
use App\Http\Requests\BaseRequest;

class ListingDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = \Auth::user();
        if ($u->can('edit-listing')) {
            return true;
        }
        $p = Listing::where('id', $this->route('id'))
            ->where('user_id', $u->id)->first();
        return (bool)$p;
    }
}
