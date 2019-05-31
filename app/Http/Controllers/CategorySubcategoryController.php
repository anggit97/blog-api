<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategorySubcategoryController extends Controller
{
    public function categorySubcategory(){
        $categories = Categories::with('subcategories')->get();
        return response()->json(['data' => $categories]);
    }
}
