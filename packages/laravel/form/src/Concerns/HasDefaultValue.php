<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait HasDefaultValue
{
    /**
     * The default value.
     *
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Set the default value.
     *
     * @return $this
     */
    public function defaultValue(mixed $value): static
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * Get the default value.
     */
    public function getDefaultValue(): mixed
    {
        return $this->defaultValue ?? $this->empty();
    }

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return null;
    }
}
