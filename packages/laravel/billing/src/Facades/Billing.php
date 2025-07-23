<?php

declare(strict_types=1);

namespace Honed\Billing\Facades;

use Honed\Billing\BillingManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Honed\Billing\Product|null find(mixed $product, ?string $name = null) Find a product by name
 * @method static \Honed\Billing\Drivers\Decorator driver(?string $name = null) Get a driver instance by name
 * @method static \Honed\Billing\Drivers\ConfigDriver createConfigDriver(string $name) Create an instance of the config driver
 * @method static \Honed\Billing\Drivers\DatabaseDriver createDatabaseDriver(string $name) Create an instance of the database driver
 * @method static string getDefaultDriver() Get the default driver name
 * @method static void setDefaultDriver(string $name) Set the default driver name
 * @method static static forgetDriver(string|array<int, string>|null $name = null) Unset the given driver instances
 * @method static static forgetDrivers() Forget all of the resolved driver instances
 * @method static static extend(string $driver, \Closure $callback) Register a custom driver creator closure
 * @method static mixed first(array<int, string> $columns = ['*']) Get the first matching product
 * @method static mixed get(array<int, string> $columns = ['*']) Get all matching products
 * @method static static whereProduct(mixed $product) Scope to the given product
 * @method static static whereProducts(string|array<int, mixed>|\Illuminate\Contracts\Support\Arrayable<int, mixed> $products) Scope to the given products
 * @method static static whereGroup(string|array<int, string>|\Illuminate\Contracts\Support\Arrayable<int, string> $group) Scope to the given product group
 * @method static static whereType(string $type) Scope to the given product type
 * @method static static wherePayment(string $payment) Scope to the given payment type
 *
 * @see BillingManager
 * @see \Honed\Billing\Contracts\Driver
 */
class Billing extends Facade
{
    /**
     * Get the root object behind the facade.
     *
     * @return BillingManager
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
