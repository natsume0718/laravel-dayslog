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

// ログインURL
Route::get('auth/twitter','Auth\LoginController@redirectToProvider')->name('login');
// コールバックURL
Route::get('auth/twitter/callback', 'Auth\LoginController@handleProviderCallback');
// ログアウトURL
Route::get('auth/twitter/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
