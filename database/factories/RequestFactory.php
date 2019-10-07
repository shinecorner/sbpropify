<?php

use App\Models\Request;
use Faker\Generator as Faker;

$factory->define(App\Models\Request::class, function (Faker $faker) {

    $category = (new App\Models\RequestCategory)->whereIn('id', [7, 8, 9])->inRandomOrder()->first();
    $tenant = (new App\Models\Tenant)->where('unit_id', '>', 0)->inRandomOrder()->first();

    $status = $faker->randomElement(array_keys(Request::Status));
    $priority = $faker->randomElement(array_keys(Request::Priority));
    $qualification = $faker->randomElement(array_keys(Request::Qualification));
    $solvedDate = $status == Request::StatusDone ? $faker->dateTimeBetween('now', '30 days') : null;

    return [
        'category_id' => $category->id,
        'tenant_id' => $tenant->id,
        'unit_id' => $tenant->unit_id,
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'status' => $status,
        'priority' => $priority,
        'qualification' => $qualification,
        'due_date' => $faker->dateTimeBetween('-30 days', '40 days'),
        'solved_date' => $solvedDate,
        'visibility' => $faker->numberBetween(1, 3),
    ];
});
