<?php

namespace App\Transformers;

use App\Models\State;
use App\Repositories\UserRepository;
use Auth;
use Config;

/**
 * Class StateTransformer.
 *
 * @package namespace App\Transformers;
 */
class StateTransformer extends BaseTransformer
{
    /**
     * @param State $model
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function transform(State $model)
    {
        $response = [
            'id' => $model->id,
            'country_id' => $model->country_id,
            'code' => $model->code,
            'name' => $model->name,
            'abbreviation' => $model->abbreviation,
        ];

//        $rl = (new RealEstate())->first();
        $userRepository = app()->make(UserRepository::class);
        $rl = $userRepository->findWithoutFail(Auth::id());

        $languages = Config::get('app.locales');
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
