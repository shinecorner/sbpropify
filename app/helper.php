<?php

function get_morph_type_of($class)
{
    return array_flip(\Illuminate\Database\Eloquent\Relations\Relation::$morphMap)[$class] ?? $class;
}

function get_translated_filed($model, $field = 'name')
{
    $currentLanguage = config('app.locale');

    if ('en' != $currentLanguage) {
        $fieldTranslation = get_translation_attribute_name($field);
        if (isset($model->{$fieldTranslation})) {
            return $model->{$fieldTranslation};
        }
    }

    return $model->{$field};
}

function get_translation_attribute_name($attribute)
{
    $currentLanguage = config('app.locale');

    if (! key_exists($currentLanguage, config('app.locales'))) {
        return $attribute;
    }

    if ('en' != $currentLanguage) {
        return $attribute . '_' . $currentLanguage;
    }

    return $attribute;
}

function update_district_to_quarter($class, $fields)
{
    $model = new $class();
    $query = $model->newQuery();
    $query->where('id', 0);
    foreach ($fields as $field) {
        $query->orWhere($field, 'like', '%district%');
    }
    $items = $query->select($fields)->addSelect('id')->get();
    foreach ($items as $item) {
        foreach ($fields as $field) {
            $value = str_replace('District', 'Quarter', $item->{$field});
            $value = str_replace('district', 'quarter', $value);
            $item->{$field} = $value;
            $item->save();
        }
    }
}