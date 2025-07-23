<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use BadMethodCallException;
use Honed\Billing\Contracts\Driver;
use Honed\Billing\Payment;
use Honed\Billing\Product;
use Honed\Billing\ProductCollection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

class Decorator implements Driver
{
    use Conditionable;
    use ForwardsCalls;
    use Macroable {
        __call as macroCall;
    }
    use Tappable;

    /**
     * The name of the driver.
     *
     * @var string
     */
    protected $name;

    /**
     * The driver to decorate.
     *
     * @var Driver
     */
    protected $driver;

    /**
     * Create a new decorator instance.
     */
    public function __construct(string $name, Driver $driver)
    {
        $this->name = $name;
        $this->driver = $driver;
    }

    /**
     * Forward the call to the decorated driver.
     *
     * @param  array<int, mixed>  $parameters
     *
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardDecoratedCallTo($this->driver, $method, $parameters);
    }

    /**
     * Get the first matching product.
     *
     * @param  array<int,string>  $columns
     */
    public function first($columns = ['*']): ?Product
    {
        /** @var array<string, mixed>|object|null */
        $product = $this->driver->first($columns);

        return $product ? $this->product((array) $product) : null;
    }

    /**
     * Get all matching products.
     *
     * @param  array<int,string>  $columns
     */
    public function get($columns = ['*']): ProductCollection
    {
        /** @var array<int, array<string, mixed>> */
        $products = $this->driver->get($columns);

        return ProductCollection::make(
            array_map(
                fn (array $product) => $this->product($product),
                $products
            )
        );
    }

    /**
     * Scope to the given product.
     *
     * @return $this
     */
    public function whereProduct(mixed $product): static
    {
        $this->driver->whereProduct($product);

        return $this;
    }

    /**
     * Scope to the given products.
     *
     * @param  string|array<int, mixed>|Arrayable<int, mixed>  $products
     * @return $this
     */
    public function whereProducts(string|array|Arrayable $products): static
    {
        $this->driver->whereProducts($products);

        return $this;
    }

    /**
     * Scope to the given product group.
     *
     * @param  string|array<int, string>|Arrayable<int, string>  $group
     * @return $this
     */
    public function whereGroup(string|array|Arrayable $group): static
    {
        $this->driver->whereGroup($group);

        return $this;
    }

    /**
     * Scope to the given product type.
     *
     * @return $this
     */
    public function whereType(string $type): static
    {
        $this->driver->whereType($type);

        return $this;
    }

    /**
     * Scope to the given payment type.
     *
     * @return $this
     */
    public function wherePayment(string $payment): static
    {
        $this->driver->wherePayment($payment);

        return $this;
    }

    /**
     * Scope to the given recurring payment type.
     *
     * @return $this
     */
    public function whereRecurring(): static
    {
        $this->driver->wherePayment(Payment::RECURRING);

        return $this;
    }

    /**
     * Scope to the given once payment type.
     *
     * @return $this
     */
    public function whereOnce(): static
    {
        $this->driver->wherePayment(Payment::ONCE);

        return $this;
    }

    /**
     * Create a new product instance.
     *
     * @param  array<string, mixed>  $product
     */
    protected function product(array $product): Product
    {

        return Product::from($product);
    }
}
