<?php

declare(strict_types=1);

use Honed\Flash\Support\Parameters;

return [

    /*
    |--------------------------------------------------------------------------
    | Duration
    |--------------------------------------------------------------------------
    |
    | Globally configure the default duration of the flash if not provided. It
    | is your discretion for implementing the duration, however, it is enforced
    | to be an integer or null. The default value is 3000.
    |
    */

    'duration' => Parameters::DURATION,

    /*
    |--------------------------------------------------------------------------
    | Type
    |--------------------------------------------------------------------------
    |
    | Globally configure the default type of the flash if not provided. It is
    | your discretion for implementing the type, however, it is enforced to be
    | a string or null.
    |
    */

    'type' => null,
];
