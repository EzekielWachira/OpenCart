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


Route::resource('/product', ProductController::class);

//Route::post('/category', 'CategoryController@addCategory')->name('category.add');
//Route::get('/categories', 'CategoryController@getAllCategories')->name('category.get');
//Route::get('/category/{id}', 'CategoryController@showCategory')->name('category.show');
//Route::patch('/category/{id}', 'CategoryController@updateCategory')->name('category.update');
//Route::delete('/category/{id}', 'CategoryController@deleteCategory')->name('category.delete');
Route::resource('/category', CategoryController::class);

Route::get('/cart', 'CartController@getAllCart')->name('cart.get');
Route::post('/cart/{id}', 'CartController@addToCart')->name('cart.add');
Route::delete('/cart/{id}', 'CartController@removeProductFromCart')->name('cart.remove');

Route::get('/wishlist', 'WishListController@getAllWishList')->name('wishlist.get');
Route::post('/wishlist/{id}', 'WishListController@addToWishlist')->name('wishlist.add');
Route::delete('/wishlist/{id}', 'WishListController@removeProductFromWishList')->name('wishlist.remove');
