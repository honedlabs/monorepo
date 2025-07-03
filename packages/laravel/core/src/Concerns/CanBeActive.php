<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanBeActive
{
    /**
     * Whether the instance is active.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Set the instance to active.
     *
     * @return $this
     */
    public function active(bool $value = true): static
    {
        $this->active = $value;

        return $this;
    }

    /**
     * Set the instance to be not be active.
     *
     * @return $this
     */
    public function notActive(bool $value = true): static
    {
        return $this->active(! $value);
    }

    /**
     * Determine if the instance is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Determine if the instance is not active.
     */
    public function isNotActive(): bool
    {
        return ! $this->isActive();
    }
}
