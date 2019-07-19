<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
| This routes for globale usage
|
*/

Route::get('/', 'HomeController@index')->name('index');
// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['enfore.tenancy']], function () {
    Auth::routes();
});
