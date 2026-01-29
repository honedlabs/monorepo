<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Property
    |--------------------------------------------------------------------------
    |
    | You can define the property name that will be used to share the flash
    | messages with Inertia. This is also the property under which the flash
    | messages will be stored in the session. The default value is `flash`.
    |
    */

    'property' => 'flash',

    /*
    |--------------------------------------------------------------------------
    | Duration
    |--------------------------------------------------------------------------
    |
    | Globally configure the default duration of the flash if not provided. It
    | is your discretion for implementing the duration, however, it is enforced
    | to be an integer or null. The default value is 3000. This duration is
    | used in the provided message implemenation, and optional if you opt to
    | implement your own.
    |
    */

    'duration' => 3000,

    /*
    |--------------------------------------------------------------------------
    | Type
    |--------------------------------------------------------------------------
    |
    | Globally configure the default type of the flash if not provided. How
    | the type is handled is dependent on your implementation of the flash
    | message.
    */

    'type' => null,

    /*
    |--------------------------------------------------------------------------
    | Implementation
    |--------------------------------------------------------------------------
    |
    | Globally configure the concrete implementation of the flash message. By
    | default, the implementation is the `Message` class provided by the
    | package - but you can customise these by implementing the
    | `Honed\Flash\Contracts\Flashable` contract.
    */

    'implementation' => Honed\Flash\Toast::class,
];
