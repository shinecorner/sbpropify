<?php

namespace App\Http\Requests\API\InternalNotice;

use App\Http\Requests\BaseRequest;
use App\Models\InternalNotice;
use Illuminate\Support\Facades\Auth;

class DeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! $this->can('delete-internal_notice')) {
            return false;
        }

        return InternalNotice::where('user_id', Auth::id())->where('id', $this->route('internalNotice'))->exists();
    }
}
