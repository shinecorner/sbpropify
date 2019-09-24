<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    // relationExists returns whether the relation named $key exists, is loaded
    // and is not null
    public function relationExists($key)
    {
        return parent::relationLoaded($key) && isset($this->$key);
    }

    public function getDiskPreName()
    {
        return $this->getTable() . '_';
    }
}
