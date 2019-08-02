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

Route::domain(config('app.base_url'))->group(function () {
    Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('login');
    Route::post('/login/admin', 'Auth\LoginController@adminLogin');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::prefix('/admin')->name('admin.')->middleware('auth:admin')->namespace('SuperAdmin')->group(function () {
        Route::get('/', 'HomeController@home')->name('home');
        Route::resource('user', 'UserController');
        Route::get('/hostname', 'HostnameController@index')->name('hostname.index');
        Route::get('/hostname/{hostname}', 'HostnameController@show')->name('hostname.show');
        Route::put('/hostname/{hostname}', 'HostnameController@block')->name('hostname.block');
    });

    // Landing Page Routes
    Route::get('/', 'HomeController@index')->name('index');

    // Registration Routes for new tenants
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Catch All Route
    Route::any('{any}', function () {
        abort(404);
    })->where('any', '.*');
});

// Email Verification Routes for new tenants
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');