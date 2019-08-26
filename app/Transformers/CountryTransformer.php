<?php

namespace App\Transformers;

use App\Models\Country;

/**
 * Class StateTransformer.
 *
 * @package namespace App\Transformers;
 */
class CountryTransformer extends BaseTransformer
{
    /**
     * @param Country $model
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function transform(Country $model)
    {
        $response = [
            'id' => $model->id,
            'code' => $model->code,
            'alpha_3' => $model->alpha_3,
            'name' => $model->name,
        ];

        $currentLanguage = config('app.locale');

        if ('en' != $currentLanguage) {
            $field = 'name_' . $currentLanguage;
            if (isset($model->{$field})) {
                $response['name'] = $model->{$field};
            }
        }

        return $response;
    }
}
