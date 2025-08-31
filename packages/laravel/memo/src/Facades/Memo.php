<?php

declare(strict_types=1);

namespace Honed\Memo\Facades;

use Honed\Memo\Contracts\Memoize;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Memo\Contracts\Memoize get(string $key) Get a memoized value
 * @method static \Honed\Memo\Contracts\Memoize put(string $key, mixed $value) Memoize a value
 * @method static \Honed\Memo\Contracts\Memoize pull(string $key) Get a memoized value and remove it from the store
 * @method static \Honed\Memo\Contracts\Memoize forget(string $key) Remove a memoized value from memory
 * @method static void clear() Clear the memoized values
 *
 * @see Memoize
 */
class Memo extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return Memoize
     */
    public static function getFacadeRoot()
    {
        /** @var Memoize */
        return parent::getFacadeRoot();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'memo';
    }
}
