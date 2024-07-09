<?php

namespace Conquest\Core\Concerns;

/**
 * Sets a value on a class
 */
trait HasValue
{
    protected mixed $value = null;

    /**
     * Set the value to be used, chainable.
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
     * Get the value to be used.
     */
    public function getValue(): mixed
    {
        return $this->evaluate($this->value);
    }
}
