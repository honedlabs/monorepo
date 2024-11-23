<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasValue
{
    /**
     * @var int|string|array|(\Closure(mixed...):mixed)|null
     */
    protected $value = null;

    /**
     * Set the value to be used, chainable.
     *
     * @param  int|string|array|(\Closure(mixed...):mixed)|null  $value
     * @return $this
     */
    public function value(mixed $value): static
    {
        $this->setValue($value);

        return $this;
    }

    /**
     * Set the value to be used quietly.
     *
     * @param  int|string|array|(\Closure(mixed...):mixed)|null  $value
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Get the value using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return int|string|array|null
     */
    public function getValue(array $named = [], array $typed = []): mixed
    {
        return $this->evaluate($this->value, $named, $typed);
    }

    /**
     * Resolve the value using the given closure dependencies.
     *
     * @param array<string, mixed> $named
     * @param array<string, mixed> $typed
     * @return int|string|array|null
     */
    public function resolveValue(array $named = [], array $typed = []): mixed
    {
        $this->setValue($this->getValue($named, $typed));

        return $this->value;
    }
}
