<?php

namespace OpenLibrary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id', 'name', 'avatar', 'address', 'phone', 'cpf'
    ];

    protected $hidden = [
        'user_id'
    ];

    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rentals()
    {
        return $this->hasMany(Book::class, 'book_id');
    }
}
