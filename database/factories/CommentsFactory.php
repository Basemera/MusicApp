<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Comments::class, function (Faker $faker) {
    return array(
        //
        'Details' => $faker->sentences(6, true),
        "song_id" => $faker->randomDigit,
        "user_id" => $faker->randomDigit

    );
});
