<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\MasterList::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->text(20),
        'price' => $faker->randomFloat(2, 1, 20),
        'ap_unit' => $faker->numberBetween(1, 16),
        'ap_quantity' => $faker->numberBetween(1, 10),
        'yield' => $faker->randomFloat(4, .8, 1),
        'vendor' => 'Test Vendor',
        'category' => 'Test Category'
    ];
});
