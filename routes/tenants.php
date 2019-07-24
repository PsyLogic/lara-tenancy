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

Route::group(['middleware' => ['web', 'enfore.tenancy'], 'namespace' => 'App\Http\Controllers'], function () {
    
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

});

// Admin/Owner Routes
Route::group(['middleware' => ['enfore.tenancy', 'web', 'role:admin|owner', 'auth'], 'namespace' => 'App\Http\Controllers\Tenants'], function () {
    Route::resource('user', 'UserController');
});

// Public Routes
Route::group(['middleware' => ['enfore.tenancy', 'web', 'verified'], 'namespace' => 'App\Http\Controllers\Tenants'], function () {
    Route::get('/', 'HomeController')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
});


