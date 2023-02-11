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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });

    Route::group([
        'namespace' => 'Auth',
        'middleware' => 'api',
        'prefix' => 'password'
    ], function () {

        Route::post('create', 'PasswordResetController@create');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@reset');
    });
});

Route::get('questions/category','FrequentlyAskedQuestionsController@categories')->name('question.category');
Route::get('questions/{category_id}','FrequentlyAskedQuestionsController@show')->name('question');
Route::post('favorites/add','UserFavoritesController@store')->middleware('auth:api');
Route::get('favorites','UserFavoritesController@index')->middleware('auth:api');
Route::delete('favorites','UserFavoritesController@destroy')->middleware('auth:api');

Route::group([
    'prefix' => 'user',
    'middleware' => 'api:auth',
    'namespace' => 'Api'
], function (){
});

