<?php

declare(strict_types=1);

namespace Honed\Lock\Facades;

use Honed\Lock\Contracts\Lockable;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Lock\Locker abilities(string|iterable<int,string> ...$abilities) Set the abilities to include in the locks.
 * @method static \Honed\Lock\Locker ability(string $ability) Set an ability to include in the locks.
 * @method static array<int,string> getAbilities() Get the abilities to include in the locks.
 * @method static array<int,string> abilitiesFromPolicy(\Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model> $model) Get the abilities from the policy.
 * @method static \Honed\Lock\Locker using(array<int,string>|(\Closure(mixed...):array<int,string>)|null $using) Set the method to use to retrieve the abilities.
 * @method static array<int,string>|null uses() Get the method to use to retrieve the abilities.
 * @method static void shouldAppend(bool $append = true) Set whether to append the locks to the model.
 * @method static bool appendsLocks() Determine if the locks should be appended to the model.
 * @method static string getProperty() Get the property name to serialize as when sharing via inertia.
 * @method static array<string,bool> all() Get locks from gate abilities.
 *
 * @see Lockable
 */
class Lock extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return Lockable
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
        return Lockable::class;
    }
}
