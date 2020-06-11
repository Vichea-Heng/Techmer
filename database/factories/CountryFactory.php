<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Addresses\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        "country" => $faker->name,
        "phone_code" => $faker->randomDigit,
    ];
});
