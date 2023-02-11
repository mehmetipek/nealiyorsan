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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    //Route::resource('roles', 'Admin\\RoleController');
    Route::get('/dashboard', 'HomeController@index')->name('admin.home');

    Route::group([
        'prefix' => 'auctions',
    ], function (){
       Route::get('/', 'AuctionController@index')->name('admin.auctions.index');
       Route::get('/{id}', 'AuctionController@edit')->name('admin.auctions.edit')->where('id', '[0-9]+');
       Route::patch('/{id}', 'AuctionController@update')->name('admin.auction.update')->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'category'
    ], function (){
        Route::get('/{parent_id?}', 'CategoryController@index')->name('admin.category.index')->where('parent_id', '[0-9]+');

        Route::get('/create/{parent_id?}', 'CategoryController@create')->name('admin.category.create')->where('parent_id', '[0-9]+');
        Route::post('/create/{parent_id?}', 'CategoryController@store')->name('admin.category.store')->where('parent_id', '[0-9]+');

        Route::get('/edit/{category_id?}', 'CategoryController@edit')->name('admin.category.edit')->where('category_id', '[0-9]+');
        Route::post('/edit/{category_id?}', 'CategoryController@update')->name('admin.category.update')->where('category_id', '[0-9]+');
        Route::get('/status/{category_id?}', 'CategoryController@status')->name('admin.category.status')->where('category_id', '[0-9]+');

        Route::get('/field/', 'FieldTypeController@index')->name('admin.field.index');
        Route::get('/field/create', 'FieldTypeController@create')->name('admin.field.create');
        Route::post('/field/create', 'FieldTypeController@store')->name('admin.field.store');
        Route::get('/field/edit/{field_type_id}', 'FieldTypeController@edit')->name('admin.field.edit');
    });


    Route::get('question/create','FrequentlyAskedQuestionsController@create')->name('admin.question.create');
    Route::post('question/create','FrequentlyAskedQuestionsController@store')->name('admin.question.store');

    Route::get('search', 'SearchLogController@index')->name('admin.search.index');
    Route::get('search/create', 'SearchLogController@create')->name('admin.search.create');



    Route::get('jx/city/{id}', function ($id) {
        $state = City::find($id);
        $city = City::where('subdivision_1_iso_code', $state->subdivision_1_iso_code)
            ->where('country_iso_code', $state->country_iso_code)
            ->whereNotNull('city_name')
            ->pluck('city_name', 'id');

        return response()->json($city);
    });

});
