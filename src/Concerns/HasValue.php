<?php

declare(strict_types=1);

namespace Conquest\Core\Concerns;

use Conquest\Core\Attributes\Value;
use ReflectionClass;

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
        return $this->evaluate($this->value) ?? $this->evaluateValueAttribute();
    }

    /**
     * Evaluate the value attribute if present
     */
    protected function evaluateValueAttribute(): ?string
    {
        $attributes = (new ReflectionClass($this))->getAttributes(Value::class);

        if (! empty($attributes)) {
            return $attributes[0]->newInstance()->getValue();
        }

        return null;
    }
}
