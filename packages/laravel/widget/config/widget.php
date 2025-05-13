<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Default Widget Store
    |--------------------------------------------------------------------------
    |
    | Here you will specify the default store that Widget should use when
    | storing and resolving widget values. Widget ships with the
    | ability to store widget values in an in-memory array or database.
    |
    | Supported: "array", "database"
    |
    */

    'default' => env('WIDGET_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Pennant Stores
    |--------------------------------------------------------------------------
    |
    | Here you may configure each of the stores that should be available to
    | Pennant. These stores shall be used to store resolved feature flag
    | values - you may configure as many as your application requires.
    |
    */

    'drivers' => [

        'array' => [
            'driver' => 'array',
        ],

        'cache' => [
            'driver' => 'cache',
            'expiration' => null
        ],

        'cookie' => [
            'driver' => 'cookie',
            'expiration' => 60 * 24 * 30
        ],

        'database' => [
            'driver' => 'database',
            'connection' => null,
            'table' => 'widgets',
        ],

    ],

];