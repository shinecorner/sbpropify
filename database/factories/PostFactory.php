<?php

use Faker\Generator as Faker;
use App\Models\Pinboard;
use App\Models\User;

$factory->define(App\Models\Pinboard::class, function (Faker $faker) {
    $us = [
        User::where('deleted_at', null)->inRandomOrder()->first(),
        User::where('email', 'tenant@example.com')->first(),
    ];
    $u = $us[rand(0, 1)];
    $statDate = $u->created_at;
    $now = now();
    $diffSec = $now->diffInSeconds($statDate);
    $now->subSeconds(random_int(1, $diffSec));

    $ret = [
        'user_id' => $u->id,
        'type' => Pinboard::TypeArticle,
        'status' => Pinboard::StatusNew,
        'visibility' => Pinboard::VisibilityAll,
        'content' => $faker->paragraph(),
        'notify_email' => true,
        'announcement' => $faker->boolean,
        'created_at' => $now,
        'updated_at' => $now,
    ];

    return $ret;
});
