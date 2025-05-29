<?php

declare(strict_types=1);

namespace Honed\Lock\Facades;

use Honed\Lock\Locker;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Lock\Locker locks(iterable<int,string> ...$locks) Set the abilities to include in the locks.
 * @method static array<int,string> getLocks() Get the abilities to include in the locks.
 * @method static \Honed\Lock\Locker using(array<int,string> $using) Set the method to use to retrieve the locks.
 * @method static array<int,string>|null uses() Get the method to use to retrieve the locks.
 * @method static \Honed\Lock\Locker appendToModels(bool $appends = true) Set whether to include the locks when serializing models.
 * @method static bool appendsToModels() Determine if the locks should be included when serializing models.
 * @method static array<string,bool> all() Get locks from gate abilities.
 * @method static array<int,string> fromPolicy(\Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model> $model) Get the abilities from the policy.
 *
 * @see Locker
 */
class Lock extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return Locker
     */
    public static function getFacadeRoot()
    {
        // @phpstan-ignore-next-line
        return parent::getFacadeRoot();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Locker::class;
    }
}
