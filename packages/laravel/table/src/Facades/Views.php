<?php

declare(strict_types=1);

namespace Honed\Table\Facades;

use Honed\Table\ViewManager;
use Illuminate\Support\Facades\Facade;

/**
 * @see ViewManager
 */
class Views extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return NavManager
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
        return ViewManager::class;
    }
}
