<?php

declare(strict_types=1);

namespace Honed\Honed\Concerns;

/**
 * @template T
 */
trait Instantiable
{
    /**
     * The instance of the class.
     *
     * @var T|null
     */
    protected $instance;

    /**
     * Create a new instance of the class.
     *
     * @param  array<int, mixed>  $arguments
     * @return T
     */
    public function instance(array $arguments = []): mixed
    {
        return $this->instance ??= new ($this->instance)(...$arguments);
    }
}