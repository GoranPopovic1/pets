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

Route::get('/', 'AdController@index');

Auth::routes();

Route::resource('ads', 'AdController');

Route::get('/profile', 'ProfileController@index')
    ->name('profile');

Route::post('/profile/update', 'ProfileController@update')
    ->name('update');

Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')
    ->name('login.provider')
    ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')
    ->name('login.callback')
    ->where('driver', implode('|', config('auth.socialite.drivers')));
