<?php

namespace App\Http\Requests\API\Audit;

use App\Http\Requests\BaseRequest;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\ServiceRequest;

class ListRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $u = $this->user();
        if ($u->can('list-audit')) {
            return true;
        }

        if (
            $u->tenant
            && !empty($this->auditable_type)
            && !empty(Relation::$morphMap[$this->auditable_type])
            && Relation::$morphMap[$this->auditable_type] == ServiceRequest::class
        ) {
            return true;
        }

        return false;
    }
}
