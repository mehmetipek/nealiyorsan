<?php
/*
|--------------------------------------------------------------------------
| Categories API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'categories',
    'middleware' => 'api'
], function () {
    Route::get('/root', 'Api\CategoryController@index')->name('api.categories.root');
    Route::get('/{parent_id}', 'Api\CategoryController@index')->name('api.categories.get_sub_categories');
    Route::get('/get/{category_id}', 'Api\CategoryController@view')->name('api.categories.get_category');
});
