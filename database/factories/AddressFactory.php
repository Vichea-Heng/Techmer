<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Addresses\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        "address_line1" => $faker->paragraph,
        "address_line2" => $faker->paragraph,
        "country_id" => 1,
        "user_id" => 1,
    ];
});
