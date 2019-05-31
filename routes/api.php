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

Route::resource('categories', 'CategoryController');

Route::resource('subcategories', 'SubcategoryController');