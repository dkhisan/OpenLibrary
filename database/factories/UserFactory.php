<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Facades\Hash;
use OpenLibrary\Models\User;

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

$factory->define(User::class, function () {
    return [
        'email' => 'admin@mail.com',
        'password' => Hash::make('qwe123'),
        'role' => 'administrador'
    ];
});
