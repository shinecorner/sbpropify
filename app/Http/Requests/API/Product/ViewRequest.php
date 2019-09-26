<?php

namespace App\Http\Requests\API\Product;

use App\Models\Product;
use App\Http\Requests\BaseRequest;

class ViewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->can('view-product');
    }
}
