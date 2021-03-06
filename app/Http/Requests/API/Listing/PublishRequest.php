<?php

namespace App\Http\Requests\API\Listing;

use App\Models\Listing;
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
        return $this->can('(un)publish-listing');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Listing::publishRules();
    }
}
