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

Route::get('/products', 'ProductController@getAll')->name('product.all');
Route::get('/product/{id}', 'ProductController@showProduct')->name('product.get');
Route::post('/product', 'ProductController@addProduct')->name('product.add');
Route::patch('/product/{id}', 'ProductController@updateProduct')->name('product.update');
Route::delete('/product/{id}', 'ProductController@deleteProduct')->name('product.delete');

Route::post('/category', 'CategoryController@addCategory')->name('category.add');
Route::get('/categories', 'CategoryController@getAllCategories')->name('category.get');
Route::get('/category/{id}', 'CategoryController@showCategory')->name('category.show');
Route::patch('/category/{id}', 'CategoryController@updateCategory')->name('category.update');
Route::delete('/category/{id}', 'CategoryController@deleteCategory')->name('category.delete');

Route::get('/cart', 'CartController@getAllCart')->name('cart.get');
Route::post('/cart', 'CartController@addToCart')->name('cart.add');
Route::delete('/cart/{id}', 'CartController@removeProductFromCart')->name('cart.remove');

