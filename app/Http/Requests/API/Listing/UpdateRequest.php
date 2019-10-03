<?php

namespace App\Http\Requests\API\Listing;

use App\Http\Requests\BaseRequest;
use App\Models\Product;

class UpdateRequest extends BaseRequest
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
        return Product::where('id', $this->route('listing'))
            ->where('user_id', $u->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Product::rules();
    }
}
