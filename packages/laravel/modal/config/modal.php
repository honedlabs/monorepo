<?php

declare(strict_types=1);

return [
    
    /*
    |--------------------------------------------------------------------------
    | Exclude middleware
    |--------------------------------------------------------------------------
    |
    | You can specify the middleware to exclude when dispatching the base URL request.
    | By default, the EncryptCookies middleware is excluded to prevent the cookies
    | from being encrypted twice and rendering them unusable.
    |
    */

    'middleware' => [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Render callbacks
    |--------------------------------------------------------------------------
    |
    | You can specify callbacks to be executed before the base route is
    | rerendered. By default, the BladeRouteGeneratorCallback is registered
    | to reset the BladeRouteGenerator state, if the class exists.
    |
    */

    'renders' => [
        \Honed\Modal\Callbacks\BladeRouteGeneratorCallback::class,
    ],
];
