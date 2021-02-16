<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBooks extends Model
{
    protected $table = 'user_books';
    protected $fillable = [
        'user_id',
        'book_id',
    ];
}
