<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Inertia Retrieval
    |--------------------------------------------------------------------------
    |
    | Here you may configure how you would like Inertia.JS to retrieve dynamic 
    | data from the server, and pass it to your pages by default. The 
    |
    | Supported: "sync", "defer", "lazy"
    |
    */

    'inertia' => 'sync',
    
    /*
    |--------------------------------------------------------------------------
    | Default Widget Driver
    |--------------------------------------------------------------------------
    |
    | Here you will specify the default driver that Widget should use when
    | storing and resolving widget values. Widget ships with the
    | ability to store widget values in an in-memory array or database.
    |
    | Supported: "array", "cache", "cookie", "database"
    |
    */

    'default' => env('WIDGET_DRIVER', 'database'), // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig

    /*
    |--------------------------------------------------------------------------
    | Widget Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may configure each of the drivers that should be available to
    | Widget. These drivers shall be used to store resolved widget values - 
    | you may configure as many as your application requires.
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