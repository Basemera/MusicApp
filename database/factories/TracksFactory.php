<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Track::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'url' => $faker->url,
        'public_id' => $faker->slug,
        'album_id' => $faker->randomDigit,
        'user_id' => $faker->randomDigit,
    ];
});
