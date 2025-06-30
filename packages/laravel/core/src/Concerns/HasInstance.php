<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Primitive;

/**
 * @template TClass
 */
trait HasInstance
{
    /**
     * The primitive instance.
     *
     * @var TClass
     */
    protected $instance;

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array<array-key,mixed>  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->getInstance()->{$method}(...$parameters);
    }

    /**
     * Set the instance to pipe.
     *
     * @param  TClass  $instance
     * @return $this
     */
    public function instance($instance): static
    {
        $this->instance = $instance;

        return $this;
    }

    /**
     * Get the instance to pipe.
     *
     * @return TClass
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
