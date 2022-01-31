<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('setClassToSidebar')) {
    function isActiveOrOpen(array $array, $className = "active")
    {
        return in_array(Route::currentRouteName(), $array) ? $className : "";
    }
}
