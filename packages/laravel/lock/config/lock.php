<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Property
    |--------------------------------------------------------------------------
    |
    | You can define the property name that will be used to share the lock gate
    | checks to your Inertia views. The default value is `lock`.
    |
    */
    'property' => 'lock',

    /*
    |--------------------------------------------------------------------------
    | Locks
    |--------------------------------------------------------------------------
    |
    | You can override the default implementation of the `Locker` class using
    | the `Honed\Lock\Contracts\Lockable` interface.
    |
    */
    'implementation' => Honed\Lock\Locker::class,
];
