<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Building::class, function (Faker $faker) {
    $address = factory(\App\Models\Address::class)->create();
    return [
        'name' => sprintf('%s %s', $address->street, $address->house_num),
        'description' => $faker->sentence(5),
        'label' => $faker->sentence(3),
        'address_id' => $address->id,
        'quarter_id' => $faker->boolean ? \App\Models\Quarter::inRandomOrder()->first()->id : null,
        'floor_nr' => $faker->numberBetween(1, 30),
        'basement' => $faker->numberBetween(0, 1),
        'attic' => $faker->numberBetween(0, 1),
        'contact_enable' => array_rand(\App\Models\Building::BuildingContactEnables),
        'internal_building_id' => $faker->boolean ? (\App\Models\Building::inRandomOrder()->first()->id ?? null) : null,
    ];
});
