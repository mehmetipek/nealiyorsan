<?php
/*
|--------------------------------------------------------------------------
| User API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth:api',
    'namespace' => 'Api',
], function () {
    Route::put('profile', 'UserController@store')->name('api.user.profile.store');

    Route::post('public/profile','UserController@show')->name('api.user.public.profile');
});
