<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        "email_verified" => 1,
        'phone_number' => "85512312" . $faker->randomDigit . $faker->randomDigit . $faker->randomDigit,
        "phone_verified" => 1,
        "password" => bcrypt("admin"),
        "status" => 1
    ];
});
