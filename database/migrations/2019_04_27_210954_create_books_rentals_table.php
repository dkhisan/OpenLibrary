<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_rentals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profile_id')
                ->unsigned();
            $table->integer('book_id')
                ->unsigned();
            $table->tinyInteger('time')
                ->nullable();
            $table->enum('state', ['reservado', 'alugado', 'devolvido', 'cancelado'])
                ->default('reservado');
            $table->timestamps();
            $table->dateTime('rent_at')
                ->nullable();

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_rentals');
    }
}
