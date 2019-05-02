<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use OpenLibrary\Models\User;
use OpenLibrary\Models\UserProfile;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
        'avatar' => 'default.png',
        'address' => $faker->address,
        'phone' => $faker->phone
    ];
});
