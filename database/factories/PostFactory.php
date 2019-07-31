<?php

use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\User;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $us = [
        User::where('deleted_at', null)->first(),
        User::where('email', 'tenant@example.com')->first(),
    ];
    $u = $us[rand(0, 1)];
    $statDate = $u->created_at;
    $now = now();
    $diffSec = $now->diffInSeconds($statDate);
    $now->subSeconds(random_int(1, $diffSec));

    $ret = [
        'user_id' => $u->id,
        'type' => Post::TypeArticle,
        'status' => Post::StatusNew,
        'visibility' => Post::VisibilityAll,
        'content' => $faker->paragraph(),
        'notify_email' => true,
        'created_at' => $now,
        'updated_at' => $now,
        'needs_approval' => true
    ];

    $realEstate = \App\Models\RealEstate::first();
    if ($realEstate) {
        $ret['needs_approval'] = $realEstate->news_approval_enable;
    }

    return $ret;
});
