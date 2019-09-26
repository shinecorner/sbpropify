<?php

namespace App\Http\Requests\API\Product;

use App\Models\Product;
use App\Http\Requests\BaseRequest;

class PublishRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('publish-product');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Product::publishRules();
    }
}
