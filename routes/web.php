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

Route::view('/', 'top')->name('top');
Route::prefix('auth/twitter')->group(function () {
    // ログインURL
    Route::get('/', 'Auth\LoginController@redirectToProvider')->name('login');
    // コールバックURL
    Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
    // ログアウトURL
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
Route::prefix('activity')->group(function () {
    Route::get('/', 'TwitterController@index')->name('activity.index');
    Route::post('/', 'TwitterController@store')->name('activity.store');
    Route::get('/{activity}', 'TwitterController@show')->name('activity.show');
    Route::post('/{activity}', 'TwitterController@tweet')->name('activity.tweet');

});

Route::get('/home', 'HomeController@index')->name('home');
