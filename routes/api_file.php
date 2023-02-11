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
    'prefix' => 'file',
    'middleware' => 'auth:api',
], function () {
    Route::get('list/{auction_id}', 'FileOrganizerController@index')->name('api.file.list');

    Route::post('store/', 'FileOrganizerController@store')->name('api.file.store');
    Route::delete('delete/', 'FileOrganizerController@destroy')->name('api.file.destroy');
    Route::put('update/', 'FileOrganizerController@update')->name('api.file.update');

    Route::get('show/{file_id}', 'FileOrganizerController@show')->name('api.file.view');
    Route::post('destroy/{file_id}', 'FileOrganizerController@destroy')->name('api.file.destroy');
});
