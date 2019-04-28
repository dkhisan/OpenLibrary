<?php

namespace OpenLibrary\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'year', 'author', 'publisher', 'cover'
    ];

    public function rent()
    {
        return $this->belongsToMany(UserProfile::class, 'books_rentals', 'book_id', 'profile_id')
            ->using(BookRental::class)
            ->withPivot('id', 'time', 'state', 'rent_at');
    }

    public function scopeIsAvailable($builder)
    {
        return $builder->where(function($query) {
            whereNotExists(function ($query) {
                $query->select()
                    ->from('books_rentals')
                    ->whereRaw('books_rentals.book_id = books.id');
            })
            ->orWhere(function ($query) {
                $query->select()
                    ->from('books_rentals')
                    ->where('state', '<>', 'alugado');
            });
        });
    }
}
