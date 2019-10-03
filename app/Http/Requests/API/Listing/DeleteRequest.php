<?php

namespace App\Http\Requests\API\Listing;

use App\Models\Product;
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
        if ($this->can('delete-listing')) {
            return true;
        }

        $u = \Auth::user();
        return Product::where('id', $this->route('listing'))
            ->where('user_id', $u->id)->exists();
    }
}
