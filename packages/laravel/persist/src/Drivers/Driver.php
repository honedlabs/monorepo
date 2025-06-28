<?php

declare(strict_types=1);

namespace Honed\Persist\Drivers;

use Illuminate\Support\Arr;

abstract class Driver
{
    /**
     * The key to be used for the instance.
     */
    protected string $key;

    /**
     * The name of the driver.
     */
    protected string $name;

    /**
     * The data to persist.
     *
     * @var array<string,mixed>
     */
    protected array $data = [];

    /**
     * The resolved data from the driver.
     *
     * @var array<string,mixed>|null
     */
    protected ?array $resolved = null;

    /**
     * Retrieve the data from the driver and set it in memory.
     *
     * @return $this
     */
    abstract public function resolve(): self;

    /**
     * Persist the current data to the driver.
     */
    abstract public function persist(): void;

    /**
     * Create a new instance of the driver.
     *
     * @param  string  $name
     * @param  string  $key
     */
    public function __construct($name, $key)
    {
        $this->name = $name;
        $this->key = $key;
    }

    /**
     * Get a value from the resolved data.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function get($key = null)
    {
        if (! $this->resolved) {
            $this->resolve();
        }

        return match (true) {
            $key => Arr::get($this->resolved ?? [], $key, null),
            default => $this->resolved,
        };
    }

    /**
     * Put the value for the given key in to an internal data driver in preparation
     * to persist it.
     *
     * @param  string|array<string,mixed>  $key
     * @param  mixed  $value
     * @return $this
     */
    public function put($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = [...$this->data, ...$key];
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }
}
