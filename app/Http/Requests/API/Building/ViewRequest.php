<?php

namespace App\Http\Requests\API\Building;

use App\Http\Requests\BaseRequest;
use App\Models\Building;

class ViewRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->can('view-building')) {
            return true;
        }

        // permit tenants to see their building
        $b = Building::where('id', $this->route('id'))->first();
        $t = $this->user()->tenant ?? null;

        return $t && $t->building_id == $b->id;
    }
}
