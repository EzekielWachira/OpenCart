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

Route::resource('/category', CategoryController::class);

Route::resource('/cart', CartController::class);


Route::get('/wishlist', 'WishListController@getAllWishList')->name('wishlist.get');
Route::post('/wishlist/{id}', 'WishListController@addToWishlist')->name('wishlist.add');
Route::delete('/wishlist/{id}', 'WishListController@removeProductFromWishList')->name('wishlist.remove');
