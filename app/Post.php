<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'foto',
        'user_id',
        'category_id'
    ];
}
