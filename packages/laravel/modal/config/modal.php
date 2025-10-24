<?php

declare(strict_types=1);

return [
    
    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Middleware
    |--------------------------------------------------------------------------
    |
    | If necessary, you may add middleware to be executed whenever a modal
    | response is needed to be returned. Typically this should be done at the
    | routing or controller level, but you can provide modal middleware if
    | necessary.
    |
    */

    'middleware' => [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
    ],
];
