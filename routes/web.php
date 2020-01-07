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

/*
	C R U D
	GET /ads (index)
	GET /ads/create (create)
	GET /ads/1 (show)
	POST /ads (store)
	POST /ads/edit (edit)
	PATCH /ads/1 (update)
	DELETE /ads/1 (destroy)
*/

//Route::resource('ads', 'AdController')
//    ->only([
//        'index', 'create',
//    ])
//    ->except([
//        'index', 'create',
//    ])
//    ->names([
//        'index' => 'ads.index',
//        'create' => 'ads.create',
//    ]);

Auth::routes(['verify' => true]);

// AUTHENTICATED USER SECTION
Route::group(['middleware' => 'auth'], function() {
    // VERIFIED ROUTE SECTION
    Route::group(['middleware' => 'verified'], function() {
        Route::resource('users', 'UserController')
            ->except(['create', 'store']);

        Route::resource('ads', 'AdController')
            ->except(['index', 'show']);

        Route::get('user/ads', 'AdController@userAds');

        Route::get('delete/ad/image/{id}', 'AdController@deleteAdImage');

        Route::resource('messages', 'MessageController');
    });
});

Route::get('/', 'AdController@index');

Route::get('/ads/{ad}', 'AdController@show');

Route::get('/search', 'AdController@search');
Route::get('/search/results', 'AdController@searchResults');
Route::post('/search/form', 'AdController@searchFormData');

Route::get('users/{id}/ads', 'AdController@usersAds');

Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));