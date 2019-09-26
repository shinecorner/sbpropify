<?php

namespace App\Http\Requests\API\UserSettings;

use App\Models\UserSettings;
use App\Http\Requests\BaseRequest;

class ShowRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('view-user_setting');
    }
}
