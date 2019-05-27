<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Album::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'released_on' => $faker->year(),
        'user_id' => $faker->randomDigit
    ];
});
