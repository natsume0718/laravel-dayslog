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

Route::view('/', 'top', ['user' => Auth::user()])->name('top');
Route::prefix('auth/twitter')->group(function () {
    // ログインURL
    Route::get('/', 'Auth\LoginController@redirectToProvider')->name('login');
    // コールバックURL
    Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
    // ログアウトURL
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
Route::group(['middleware' => 'user.name', 'prefix' => 'activity'], function () {
    Route::get('{user_name}/', 'TwitterController@index')->name('activity.index');
    Route::post('{user_name}/', 'TwitterController@store')->name('activity.store');
    Route::get('{user_name}/{activity}', 'TwitterController@show')->name('activity.show');
    Route::post('{user_name}/{activity}', 'TwitterController@tweet')->name('activity.tweet');

});

Route::get('/home', 'HomeController@index')->name('home');
