<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\Identity;
use Faker\Generator as Faker;

$factory->define(Identity::class, function (Faker $faker) {
    return [
        "user_id" => $faker->unique()->numberBetween(2, 11),
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "date_of_birth" => $faker->dateTimeBetween('-20 years', '-10 years', null),
    ];
});
