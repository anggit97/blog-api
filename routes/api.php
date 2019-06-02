<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function(){

    Route::namespace('Auth')->group(function(){
        Route::get('me', 'AuthController@me');
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout'); 
        Route::post('refresh', 'AuthController@refresh');    
    });
});

Route::middleware('auth:api')->group(function(){
    
    Route::prefix('profile')->group(function(){

        Route::namespace('User')->group(function(){
            Route::get('me', 'ProfileController@me');
            Route::post('me/avatar', 'ProfileController@updateAvatar');
        });
    });
});


Route::resource('categories', 'CategoryController');

Route::resource('subcategories', 'SubcategoryController');

Route::resource('tags', 'TagController');

Route::resource('posts', 'PostController');

Route::get('categor', 'CategorySubcategoryController@categorySubcategory');