<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'web', 'verified']], function () {
    Route::namespace('\App\Keeper\Category\Http\Controllers')->group(function () {
        Route::get('categories', 'CategoryController@index')->name('categories');
    });

    Route::namespace('\App\Keeper\Wishlist\Http\Controllers')->group(function () {
        Route::get('wishlists', 'WishlistController@index')->name('wishlists');
        Route::get('wishlists/create', 'WishlistController@create')->name('wishlists/create');
        Route::post('wishlists/store', 'WishlistController@store')->name('wishlists/store');
        Route::post('wishlists/addproduct', 'WishlistController@addproduct')->name('wishlists/addproduct');

        Route::group(['middleware' => ['ensurewishlistisnotdefault']], function () {
            Route::post('wishlists/delete', 'WishlistController@delete')->name('wishlists/delete');
            Route::get('wishlists/edit/{id}', 'WishlistController@edit')->name('wishlists/edit');
            Route::post('wishlists/update/{id}', 'WishlistController@update')->name('wishlists/update');
        });

        Route::group(['middleware' => ['ensurenodefaultwishlist']], function () {
            Route::get('wishlists/createdefault', 'WishlistController@createdefault')->name('wishlists/createdefault');
            Route::post('wishlists/storedefault', 'WishlistController@storedefault')->name('wishlists/storedefault');
        });
    });

    Route::group(['middleware' => ['ensurehasdefaultwishlist']], function () {
        Route::namespace('\App\Keeper\Product\Http\Controllers')->group(function () {
            Route::get('products', 'ProductsController@index')->name('products');
        });
    });
});
