<?php

declare(strict_types=1);

namespace Honed\Lock\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Honed\Lock\Locker
 * 
 * @method static \Honed\Lock\Locker locks(array $locks) Set the abilities to use to generate the locks.
 * @method static array getLocks() Get the abilities to use to generate the locks.
 * @method static \Honed\Lock\Locker includeLocks(bool $includeLocks) Set whether to include the locks when serializing models.
 * @method static bool includesLocks() Determine if the locks should be included when serializing models.
 * @method static array generateLocks() Get locks from gate abilities.
 * @method static array getAbilitiesFromPolicy(\Illuminate\Database\Eloquent\Model $model) Get the abilities from the policy.
 */
class Lock extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Honed\Lock\Locker::class;
    }
}