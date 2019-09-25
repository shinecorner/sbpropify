<?php

namespace App\Http\Requests\API\Dashboard;

use App\Http\Requests\BaseRequest;

class PieChartStatisticRequest extends BaseRequest
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
