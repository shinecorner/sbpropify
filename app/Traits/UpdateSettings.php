<?php

namespace App\Traits;

use BeyondCode\Comments\Traits\HasComments as OriginalHasTraits;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UpdateSettings
{
    public function updateRelations($model, $attributes)
    {
        if (key_exists('settings', $attributes)) {
            $settingData = $attributes['settings'];
            $model->load('settings');
            $settings = $model->settings;

            if($settings) {
                $settings->update($settingData);
            } else {
                $newSetting = $model->settings()->create($settingData);
                $model->setRelation('settings', $newSetting);
            }
        }

        return $model;
    }
}
