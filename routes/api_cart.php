<?php
/*
|--------------------------------------------------------------------------
| File API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'cart',
    'middleware' => 'auth:api',
    'namespace' => 'Api'
], function () {
    Route::get('/', 'CartController@index')->name('api.cart.index');
    Route::post('add/', 'CartController@store')->name('api.file.store');
    Route::delete('remove/', 'CartController@destroy')->name('api.file.destroy');

});
