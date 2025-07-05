<?php

declare(strict_types=1);

namespace Honed\Stats\Concerns;

trait FromData
{
    /**
     * The data to evaluate.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Set the value to evaluate.
     *
     * @return $this
     */
    public function from(mixed $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value to evaluate.
     */
    public function dataFrom(): mixed
    {
        if (is_callable($this->data)) {
            return call_user_func($this->data);
        }

        return $this->data;
    }
}
