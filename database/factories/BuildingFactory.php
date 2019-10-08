<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Building::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3) ,
        'description' => $faker->sentence(5),
        'label' => $faker->sentence(3),
        'address_id' => 1,
        'quarter_id' => $faker->boolean ? \App\Models\Quarter::inRandomOrder()->first()->id : null,
        'floor_nr' => $faker->numberBetween(1, 30),
        'basement' => $faker->numberBetween(0, 1),
        'attic' => $faker->numberBetween(0, 1),
        'contact_enable' => $faker->boolean,
        'internal_building_id' => $faker->boolean ? (\App\Models\Building::inRandomOrder()->first()->id ?? null) : null,
    ];
});
