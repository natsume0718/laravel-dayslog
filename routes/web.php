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
    return view('top', ['user' => Auth::user()]);
})->name('top');
Route::prefix('auth/twitter')->group(function () {
    // ログインURL
    Route::get('/', 'Auth\LoginController@redirectToProvider')->name('login');
    // コールバックURL
    Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
    // ログアウトURL
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
Route::group(['middleware' => ['auth', 'user.name'], 'prefix' => 'activity'], function () {
    Route::get('{user_name}/', 'ActivityController@index')->name('activity.index');
    Route::post('{user_name}/', 'ActivityController@store')->name('activity.store');
    Route::get('{user_name}/{activity}', 'ActivityController@show')->name('activity.show');
    Route::patch('{user_name}/{activity}', 'ActivityController@update')->name('activity.tweet');
    Route::delete('{user_name}/{activity}', 'ActivityController@destroy')->name('activity.delete');
    Route::delete('{user_name}/{activity}/{id}', 'ActivityController@deleteTweet')->name('tweet.delete');
});
