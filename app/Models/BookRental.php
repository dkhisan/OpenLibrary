<?php

namespace OpenLibrary\Models;

use Illuminate\Database\Eloquent\Model;

class BookRental extends Model
{
    protected $table = 'books_rentals';

    protected $fillable = [
        'profile_id', 'book_id', 'time', 'state', 'rent_at'
    ];

    protected $hidden = [
        'profile_id', 'book_id'
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeIsReserved($builder)
    {
        return $builder->where('state', 'reservado');
    }

    public function scopeIsRented($builder)
    {
        return $builder->where('state', 'alugado');
    }

    public function scopeIsReturned($builder)
    {
        return $builder->where('state', 'devolvido');
    }

    public function scopeIsCanceled($builder)
    {
        return $builder->where('state', 'devolvido');
    }
}
