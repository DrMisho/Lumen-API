<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'email',
        'github',
        'twitter',
        'location',
        'latest_artical_publised',
    ];

    protected $hidden = [];
}
