<?php

namespace App\Http\Requests\API\Post;

use App\Http\Requests\BaseRequest;

class LikeRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
