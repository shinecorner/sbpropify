<?php

namespace App\Http\Requests\API\Tenant;

use App\Models\ServiceRequest;
use App\Http\Requests\BaseRequest;

class DownloadPdfRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->can('download_pdf-request');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
