<?php

namespace App\Http\Requests\API\Product;

use App\Models\Product;
use InfyOm\Generator\Request\APIRequest;

class DeleteRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = \Auth::user();
        if ($u->can('delete-product')) {
            return true;
        }
        return Product::where('id', $this->route('product'))
            ->where('user_id', $u->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
