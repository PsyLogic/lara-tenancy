<?php

namespace App\Helpers;

class _Tenant
{


    public static function view($view = null, $data = [], $mergeData = [])
    {
        return view('tenant.' . $view, $data, $mergeData);
    }
}
