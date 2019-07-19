<?php

/*
|--------------------------------------------------------------------------
| Tenants Routes
|--------------------------------------------------------------------------
|
| Here is where you can register tenants routes for your application. 
| Routes loaded whenever a tenant was identified
|
*/

Route::group(['middleware' => ['enfore.tenancy', 'web'], 'namespace' => 'App\Http\Controllers\Tenants'], function () {
    Route::get('/', 'HomeController');
    Route::get('/profile', 'ProfileController@index')->name('profile');
});
