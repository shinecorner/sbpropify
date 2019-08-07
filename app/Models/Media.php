<?php

namespace App\Models;

use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
        });
    }
}
