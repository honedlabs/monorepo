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
    | You can override the default implementation of the `Locker` class with
    | your own class which implements the `Honed\Lock\Contracts\Lockable`
    | interface. By default, the `Honed\Lock\Locker` class is used.
    |
    */
    'implementation' => Honed\Lock\Locker::class,
];
