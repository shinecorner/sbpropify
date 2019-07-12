<?php

namespace App\Traits;

use BeyondCode\Comments\Traits\HasComments as OriginalHasTraits;
use BeyondCode\Comments\Contracts\Commentator;
use Illuminate\Database\Eloquent\Model;

trait UniqueIDFormat
{
    /**
     * @param $id
     * @return mixed
     */
    public function getUniqueIDFormat($id){

        $table = $this->getTable();
        $date = now();

        switch($table){

            case 'tenants':

                $format = env('TENANT_FORMAT');

                break;

        }

        return str_replace(['ID', 'YYYYMMDD'], [$id, $date->format('Ymd')], $format);
    }
}
