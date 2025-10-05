<?php

declare(strict_types=1);

namespace Honed\Lang\Facades;

use Honed\Lang\LangManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see LangManager
 */
class Lang extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return LangManager
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
        return 'lang';
    }
}
