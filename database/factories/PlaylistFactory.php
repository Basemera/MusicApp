<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Playlist::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'tracks' => $faker->randomElements()
    ];
});
