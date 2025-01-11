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
     * Set the value for the instance.
     *
     * @return $this
     */
    public function value(mixed $value): static
    {
        if (! \is_null($value)) {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * Get the value for the instance.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Determine if the instance has an value set.
     */
    public function hasValue(): bool
    {
        return isset($this->value);
    }
}
