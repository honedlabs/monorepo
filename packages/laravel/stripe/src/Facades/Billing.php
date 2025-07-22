<?php

declare(strict_types=1);

namespace Honed\Billing\Facades;

use Honed\Billing\BillingManager;
use Illuminate\Support\Facades\Facade;

/**
 */
class Billing extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return \Honed\Billing\BillingManager
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
        return BillingManager::class;
    }
}