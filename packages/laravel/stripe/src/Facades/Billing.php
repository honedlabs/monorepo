<?php

declare(strict_types=1);

namespace Honed\Billing\Facades;

use Honed\Billing\BillingManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Billing\Billing|null find(mixed $product, ?string $name = null) Find a product by name
 * @method static \Honed\Billing\Contracts\Driver driver(?string $name = null) Get a driver instance by name
 * @method static \Honed\Billing\Drivers\ConfigDriver createConfigDriver(string $name) Create an instance of the config driver
 * @method static \Honed\Billing\Drivers\DatabaseDriver createDatabaseDriver(string $name) Create an instance of the database driver
 * @method static string getDefaultDriver() Get the default driver name
 * @method static void setDefaultDriver(string $name) Set the default driver name
 * @method static static forgetDriver(string|array|null $name = null) Unset the given driver instances
 * @method static static forgetDrivers() Forget all of the resolved driver instances
 * @method static static extend(string $driver, \Closure $callback) Register a custom driver creator closure
 * 
 * @method static mixed first(array $columns = ['*']) Get the first matching product
 * @method static mixed get(array $columns = ['*']) Get all matching products
 * @method static static whereProduct(mixed $product) Scope to the given product
 * @method static static whereProducts(string|array|\Illuminate\Contracts\Support\Arrayable $products) Scope to the given products
 * @method static static whereGroup(string|array|\Illuminate\Contracts\Support\Arrayable $group) Scope to the given product group
 * @method static static whereType(string $type) Scope to the given product type
 * @method static static wherePayment(string $payment) Scope to the given payment type
 * 
 * @see \Honed\Billing\BillingManager
 * @see \Honed\Billing\Contracts\Driver
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