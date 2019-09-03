<?php

namespace App\Transformers;

use App\Models\Quarter;

/**
 * Class QuarterTransformer.
 *
 * @package namespace App\Transformers;
 */
class QuarterTransformer extends BaseTransformer
{
    /**
     * Transform the QuarterT entity.
     *
     * @param \App\Models\Quarter $model
     *
     * @return array
     */
    public function transform(Quarter $model)
    {
        $response = [
            'id' => $model->id,
            'name' => $model->name,
            'quarter_format' => $model->quarter_format,
            'district_format' => $model->quarter_format,
            'description' => $model->description,
        ];

        return $response;
    }
}
