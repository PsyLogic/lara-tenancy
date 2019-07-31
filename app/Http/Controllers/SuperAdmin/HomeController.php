<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Dashboard
     */
    public function home(){
        return view('super_admin.home');
    }

}
