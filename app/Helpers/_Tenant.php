<?php

namespace App\Helpers;

class _Tenant
{


    public static function view(string $view)
    {
        return view('tenant.' . $view);
    }
}
