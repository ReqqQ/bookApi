<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'book';
    protected $fillable = [
        'title',
        'description',
        'shortDescription',
    ];

}
