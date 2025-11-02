<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

trait CanBeDisabled
{
    /**
     * Whether the component should be disabled.
     *
     * @var bool
     */
    protected $disabled = false;

    /**
     * Set the component to be disabled.
     *
     * @return $this
     */
    public function disabled(bool $value = true): static
    {
        $this->disabled = $value;

        return $this;
    }

    /**
     * Set the component to not be disabled.
     *
     * @return $this
     */
    public function dontDisable(bool $value = true): static
    {
        return $this->disabled(! $value);
    }

    /**
     * Determine if the component is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Determine if the component is not disabled.
     */
    public function isNotDisabled(): bool
    {
        return ! $this->isDisabled();
    }
}
