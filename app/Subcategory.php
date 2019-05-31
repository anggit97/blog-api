<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = ['name', 'description', 'foto'];

    public function categories(){
        return $this->belongsToMany('App\Categories', 'categories', 'category_id', 'subcategory_id');
    }
}
