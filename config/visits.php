<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Engine & Connection Name
    |--------------------------------------------------------------------------
    |
    | Supported Engines: "redis", "eloquent"
    | Connection Name: see config/database.php
    |
    */
    'engine' => \Awssat\Visits\DataEngines\EloquentEngine::class,
    'connection' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Counters periods
    |--------------------------------------------------------------------------
    |
    | Record visits (total) of each one of these periods in this set (can be empty)
    |
    */
    'periods' => [
        'day',
        'week',
        'month',
        'year',
    ],

    'keys_prefix' => 'visits',
    'remember_ip' => 15 * 60,
    'always_fresh' => false,
    'ignore_crawlers' => true,
    'global_ignore' => ['country'],
];
