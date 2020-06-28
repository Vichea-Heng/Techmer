<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Addresses\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        "address_line1" => $faker->address,
        "address_line2" => $faker->address,
        "country_id" => $faker->numberBetween(1, 246),
    ];
});
