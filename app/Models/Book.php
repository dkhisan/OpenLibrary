<?php

namespace OpenLibrary\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'year', 'author', 'publisher', 'cover'
    ];

    public function scopeIsAvailable($builder)
    {
        return $builder->where(function ($query) {
            $query->whereNotExists(function ($query) {
                $query->select()
                    ->from('books_rentals')
                    ->whereRaw('book_id = books.id');
            })
            ->orWhereExists(function ($query) {
                $query->select()
                    ->from('books_rentals')
                    ->where([
                        ['state', '<>', 'alugado'],
                        ['state', '<>', 'reservado']
                    ]);
            });
        });
    }

    public function scopeIsReserved($builder)
    {
        return $builder->where('state', 'reservado');
    }

    public function scopeIsRented($builder)
    {
        return $builder->select('time')->where('state', 'alugado');
    }

    public function scopeWithState($builder)
    {
        return $builder
            ->leftJoin('books_rentals', 'book_id', 'books.id');
    }
}
