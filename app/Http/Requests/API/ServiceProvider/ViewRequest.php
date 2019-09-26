<?php

namespace App\Http\Requests\API\ServiceProvider;

use App\Models\ServiceProvider;
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
        $u = $this->user();
        if ($u->can('view-provider')) {
            return true;
        }
        $p = ServiceProvider::where('id', $this->route('id'))->first();
        if (!$p) {
            return false;
        }

        return $p->user_id == $u->id;
    }
}
