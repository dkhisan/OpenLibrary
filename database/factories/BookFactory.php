<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use OpenLibrary\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'year' => $faker->date('Y'),
        'author' => $faker->name,
        'publisher' => $faker->company,
        'cover' => 'default.png'
    ];
});
