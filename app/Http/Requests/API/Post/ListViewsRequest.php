<?php

namespace App\Http\Requests\API\Post;

use App\Models\Post;
use App\Http\Requests\BaseRequest;

class ListViewsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('list_views-post');
    }
}
