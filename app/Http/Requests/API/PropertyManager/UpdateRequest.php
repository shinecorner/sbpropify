<?php

namespace App\Http\Requests\API\PropertyManager;

use App\Models\PropertyManager;
use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->can('edit-property_manager')) {
            return true;
        }

        return PropertyManager::where('id', $this->route('id'))->where('user_id', $this->user()->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return PropertyManager::$rulesUpdate;
    }
}
