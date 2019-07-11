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

Route::get('/', function () {
    return view('tenant.home');
});

Route::get('/home', function () {
    echo "Tenant Home";
});