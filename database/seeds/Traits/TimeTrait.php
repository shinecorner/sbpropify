<?php

namespace Traits;

use Carbon\Carbon;

trait TimeTrait
{
    public function getRandomTime($statDate = null)
    {
        if (is_null($statDate)) {
            $statDate = Carbon::create(2019);
        }

        $now = now();

        $diffSec = $now->diffInSeconds($statDate);
        return $statDate->addSeconds(random_int(1, $diffSec));
    }

    public function  getDateColumns($date)
    {
        return [
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
