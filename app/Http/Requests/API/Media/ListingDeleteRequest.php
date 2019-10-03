<?php

namespace App\Http\Requests\API\Media;

use App\Models\Product;
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
        if ($u->can('edit-product')) {
            return true;
        }
        $p = Product::where('id', $this->route('id'))
            ->where('user_id', $u->id)->first();
        return (bool)$p;
    }
}
