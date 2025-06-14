<?php

declare(strict_types=1);

namespace Honed\Refine\Persistence;

abstract class Driver
{
    /**
     * The data to persist.
     *
     * @var array<string,mixed>
     */
    protected $data = [];

    /**
     * The resolved data from the driver.
     *
     * @var mixed
     */
    protected $resolved = [];

    /**
     * The key to be used for the instance.
     *
     * @var string
     */
    protected $key;

    /**
     * Retrieve the data from the driver and store it in memory.
     *
     * @return $this
     */
    abstract public function resolve();

    /**
     * Persist the data to the session.
     *
     * @return void
     */
    abstract public function persist();

    /**
     * Create a new instance of the driver.
     *
     * @param  string  $key
     * @return static
     */
    public static function make($key)
    {
        return resolve(static::class)
            ->key($key)
            ->resolve();
    }

    /**
     * Set the key to be used for the driver.
     *
     * @param  string  $key
     * @return $this
     */
    public function key($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get a value from the resolved data.
     *
     * @param  string|null  $key
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key) {
            return $this->resolved[$key] ?? null;
        }

        return $this->resolved;
    }

    /**
     * Put the value for the given key in to an internal data store in preparation
     * to persist it.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function put($key, $value)
    {
        $this->data[$key] = $value;
    }
}
