<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product', 'ProductController@getAll')->name('product.all');
Route::get('/product/{id}', 'ProductController@showProduct')->name('product.get');
Route::post('/product', 'ProductController@addProduct')->name('product.add');
Route::patch('/product/{id}', 'ProductController@updateProduct')->name('product.update');
Route::delete('/product/{id}', 'ProductController@deleteProduct')->name('product.delete');
