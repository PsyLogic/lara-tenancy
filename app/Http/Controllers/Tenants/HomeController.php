<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Helpers\_Tenant;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        return _Tenant::view('home');
    }
}
