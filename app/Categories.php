<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subcategory;

class Categories extends Model
{
    //
    protected $fillable = [
        'name',
        'foto',
        'description'
    ];
    
    public function subcategories(){
        return $this->hasMany(Subcategory::class, 'id');
    }
}
