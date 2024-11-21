<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasValue
{
    /**
     * @var int|string|array|(\Closure():int|string|array)|null
     */
    protected $value = null;

    /**
     * Set the value to be used, chainable.
     *
     * @param  int|string|array|(\Closure():int|string|array)|null  $value
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
     * @param  int|string|array|(\Closure():int|string|array)|null  $value
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Get the value.
     *
     * @return int|string|array|(\Closure():int|string|array)|null
     */
    public function getValue(): mixed
    {
        return $this->evaluate($this->value);
    }
}
