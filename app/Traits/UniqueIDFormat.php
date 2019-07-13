<?php

namespace App\Traits;

use BeyondCode\Comments\Traits\HasComments as OriginalHasTraits;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UniqueIDFormat
{
    /**
     * @param $id
     * @return mixed
     */
    public function getUniqueIDFormat($id){

        $date = now();
        $format = $this->getTable();
        $format = Str::singular($format);
        $format = strtoupper($format);
        $format .= '_FORMAT';
        $format = env($format, 'TE-YYYYMMDD150ID');
        return str_replace(['ID', 'YYYYMMDD'], [$id, $date->format('Ymd')], $format);
    }
}
