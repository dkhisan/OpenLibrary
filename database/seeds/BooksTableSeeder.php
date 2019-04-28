<?php

use Illuminate\Database\Seeder;
use OpenLibrary\Models\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Book::class, 50)->create();
    }
}
