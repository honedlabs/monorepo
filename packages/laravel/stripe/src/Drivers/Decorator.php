<?php

declare(strict_types=1);

namespace Honed\Billing\Drivers;

use Honed\Billing\Concerns\Driver;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;

class Decorator implements Driver
{
    use ForwardsCalls;
    use Macroable {
        __call as macroCall;
    }

    /**
     * The name of the driver.
     * 
     * @var string
     */
    protected $name;

    /**
     * The driver to decorate.
     * 
     * @var \Honed\Billing\Concerns\Driver
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
     * @param string $method
     * @param array $parameters
     * @return mixed
     * 
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardDecoratedCallTo($this->driver, $method, $parameters);
    }

    public function first()
    {
        return $this->driver->first();
    }

    public function get()
    {
        return $this->driver->get();
    }

    public function whereProduct(mixed $product): static
    {
        return $this->driver->whereProduct($product);
    }

    public function whereProducts(mixed|array|Arrayable $products): static
    {
        return $this->driver->whereProducts($products);
    }

    public function whereGroup(string|array|Arrayable $group): static
    {
        return $this->driver->whereGroup($group);
    }

    public function whereType(string $type): static
    {
        return $this->driver->whereType($type);
    }

    public function wherePayment(string $payment): static
    {
        return $this->driver->wherePayment($payment);
    }
}