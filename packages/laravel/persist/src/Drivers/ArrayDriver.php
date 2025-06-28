<?php

declare(strict_types=1);

namespace Honed\Persist\Drivers;

class ArrayDriver extends Driver
{
    public const NAME = 'array';

    /**
     * The persisted data.
     *
     * @var array<string,mixed>
     */
    protected array $persisted = [];

    /**
     * Retrieve the data from the driver and put it in memory.
     *
     * @return $this
     */
    public function resolve(): self
    {
        $this->resolved = $this->persisted;

        return $this;
    }

    /**
     * Persist the data to the array.
     */
    public function persist(): void
    {
        $this->persisted = $this->resolved;
    }
}
