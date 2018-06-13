<?php
use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name'           => $faker->firstName,
        'last_name'            => $faker->lastName,
        'email'                => $faker->unique()->safeEmail,
        'country'              => $faker->country,
        'gender'               => 'other',
    ];
});

$factory->state(App\User::class, 'female', [
    'gender' => 'female',
]);
$factory->state(App\User::class, 'male', [
    'gender' => 'male',
]);
