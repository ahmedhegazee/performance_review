<?php

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return auth()->user()->is_admin;
    }
}
