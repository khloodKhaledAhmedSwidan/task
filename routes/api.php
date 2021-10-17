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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::post('register', 'AuthController@register');

        Route::post('login', 'AuthController@login');

        Route::post('verification-code', 'AuthController@confirm');

        Route::group(['middleware' => 'auth:api'], function () {
            // Logout
            Route::post('logout', 'AuthController@logout');
        });
    });

    Route::namespace('General')->group(function () {
        Route::get('categories', 'GeneralController@categories');
        Route::post('products', 'GeneralController@products');
    });
    Route::namespace('User')->group(function () {
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('add-to-cart', 'CartController@addToCart');
            Route::get('delete-all-item', 'CartController@deleteAllItemInCart');
            Route::post('delete-one-item', 'CartController@deleteItemFromCart');
            Route::get('show-cart', 'CartController@showCart');
            Route::post('send-order', 'CartController@sendOrder');
        });
    });
});
