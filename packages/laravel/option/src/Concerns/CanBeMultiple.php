<?php

declare(strict_types=1);

namespace Honed\Option\Concerns;

trait CanBeMultiple
{
    /**
     * Whether the instance is multiple.
     *
     * @var bool
     */
    protected $multiple = false;

    /**
     * Set whether the instance is multiple.
     *
     * @return $this
     */
    public function multiple(bool $value = true): static
    {
        $this->multiple = $value;

        return $this;
    }

    /**
     * Set whether the instance is not multiple.
     *
     * @return $this
     */
    public function notMultiple(bool $value = true): static
    {
        return $this->multiple(! $value);
    }

    /**
     * Determine if the instance is multiple.
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * Determine if the instance is not multiple.
     */
    public function isNotMultiple(): bool
    {
        return ! $this->isMultiple();
    }
}
