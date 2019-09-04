<?php

use Faker\Generator as Faker;
use App\Models\Product;
use App\Models\User;

$factory->define(App\Models\Product::class, function (Faker $f) {
    $u = [
        User::where('deleted_at', null)->inRandomOrder()->first(),
        User::where('email', 'tenant@example.com')->first(),
    ][rand(0, 1)];
    $t = [Product::TypeSell, Product::TypeLend][rand(0, 1)];

    $statDate = $u->created_at;
    $now = now();
    $diffSec = $now->diffInSeconds($statDate);
    $now->subSeconds(random_int(1, $diffSec));

    $ret = [
        'user_id' => $u->id,
        'type' => $t,
        'status' => Product::StatusPublished,
        'visibility' => Product::VisibilityAll,
        'content' => $f->paragraph(),
        'title' => $f->sentence(),
        'published_at' => \Carbon\Carbon::now(),
        'contact' => implode(" ", [$f->firstName, $f->lastName, $f->phoneNumber]),
        'price' => '1.10',
        'created_at' => $now,
        'updated_at' => $now,
    ];

    if ($u->tenant && $u->tenant->building) {
        $ret['address_id'] = $u->tenant->building->address_id;
        $ret['quarter_id'] = $u->tenant->building->quarter_id;
    }

    return $ret;
});
