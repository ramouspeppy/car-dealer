<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('frontend_theme')) {
    function frontend_theme()
    {
        // dealer-theme-v1
        return cache()->rememberForever('frontend_theme', function () {
            return DB::table('web_settings')->where('name', 'frontend_theme')->value('value') ?? 'dealer-theme-v1';
        });
    }
}
