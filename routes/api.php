<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',  'Auth\RegisterController@register')->name('user.register');
Route::post('/login', 'Auth\LoginController@login')->name('user.login');
Route::post('/admin/login', 'Admin\AdminController@login')->name('admin.login');
Route::post('/admin/register', 'Admin\AdminController@register')->name('admin.register');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', 'User\UserController@getUsers')->name('users.all');
    Route::post('/logout', 'Auth\LoginController@logout')->name('user.logout');
    Route::get('/products', 'ProductController@getAll')->name('product.all');

    Route::get('/admins', 'Admin\AdminController@listAllAdmins')->name('admin.all');

    Route::get('/product/{id}', 'ProductController@showProduct')->name('product.get');
    Route::post('/product', 'ProductController@addProduct')->name('product.add');
    Route::put('/product/{id}', 'ProductController@updateProduct')->name('product.update');
    Route::delete('/product/{id}', 'ProductController@deleteProduct')->name('product.delete');

    Route::post('/category', 'CategoryController@addCategory')->name('category.add');
    Route::get('/categories', 'CategoryController@getAllCategories')->name('category.get');
    Route::get('/category/{name}', 'CategoryController@show')->name('category.show');
    Route::put('/category/{id}', 'CategoryController@updateCategory')->name('category.update');
    Route::delete('/category/{id}', 'CategoryController@deleteCategory')->name('category.delete');

    Route::get('/cart', 'CartController@getAllCart')->name('cart.get');
    Route::post('/cart/{id}', 'CartController@addToCart')->name('cart.add');
    Route::delete('/cart/{id}', 'CartController@removeProductFromCart')->name('cart.remove');

    Route::get('/wishlist', 'WishListController@getAllWishList')->name('wishlist.get');
    Route::post('/wishlist/{id}', 'WishListController@addToWishlist')->name('wishlist.add');
    Route::delete('/wishlist/{id}', 'WishListController@removeProductFromWishList')->name('wishlist.remove');
});


