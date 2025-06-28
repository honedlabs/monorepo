<?php

declare(strict_types=1);

use Honed\Persist\Drivers\Driver;
use Illuminate\Support\Traits\Macroable;

class Decorator
{
    use Macroable;
    
    /**
     * The scope of the decorator.
     */
    protected string $scope;

    /**
     * The underlying driver.
     */
    protected Driver $driver;

    /**
     * Create a new decorator instance.
     */
    public function __construct(
        string $scope,
        Driver $driver,
    ) {
        $this->scope = $scope;
        $this->driver = $driver;
    }

    /**
     * Get the scope of the decorator.
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * Get the underlying driver.
     */
    public function getDriver(): Driver
    {
        return $this->driver;
    }

    /**
     * Get a value from the store.
     */
    public function get(?string $key = null): mixed
    {
        return $this->getDriver()->get($this->getScope(), $key);
    }

    /**
     * Put a value into the store.
     */
    public function put(string|array $key, mixed $value = null): self
    {
        $this->getDriver()->put($this->getScope(), $key, $value);

        return $this;
    }

    /**
     * Persist the data to the driver.
     */
    public function persist(): void
    {
        $this->getDriver()->persist($this->getScope());
    }
}