<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasValue
{
    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * Set the value to be used, chainable.
     *
     * @return $this
     */
    public function value(mixed $value): static
    {
        $this->setValue($value);

        return $this;
    }

    /**
     * Set the value to be used quietly.
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Get the value using the given closure dependencies.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
