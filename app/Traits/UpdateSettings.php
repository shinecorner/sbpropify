<?php

namespace App\Traits;

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
