<?php

use Faker\Generator as Faker;

$factory->define(\App\Album::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'released_on' => $faker->date()
    ];
});
