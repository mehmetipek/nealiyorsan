<?php
/*
|--------------------------------------------------------------------------
| Auctions API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auction',
    'middleware' => 'auth:api',
], function () {
    Route::get('/my', 'Api\AuctionController@index')->name('api.auctions.my');
    Route::get('/user', 'Api\AuctionController@user_auctions')->name('api.auctions.user');
    Route::get('/drafts', 'Api\AuctionController@drafts')->name('api.auctions.drafts');

    Route::group(['prefix' => 'create'], function () {
        Route::post('/request', 'Api\AuctionController@createRequest')->name('api.auctions.create_request');
        Route::post('/update', 'Api\AuctionController@update')->name('api.auctions.update');
        Route::post('/profile_picture/{auction_id}/{file_id}', 'Api\AuctionController@setProfilePicture');

    });
    Route::post('/statusChange', 'Api\AuctionController@statusChange')->name('api.auctions.status.change');
    Route::post('/complaint', 'Api\AuctionController@complaint')->name('complaint.create');

});

Route::group([
    'prefix' => 'auction',
    'namespace' => 'Api'
], function () {
    Route::get('/last{limit}', 'AuctionController@last')->name('api.auctions.last')->where('limit', '[0-9]+');
    Route::get('/{id}/{full?}', 'AuctionController@view')->name('api.auctions.view')->where('id', '[0-9]+');
});
