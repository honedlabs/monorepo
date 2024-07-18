<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set an active property on a class
 */
trait IsActive
{
    protected bool|Closure $active = false;

    /**
     * Set the active property, chainable.
     */
    public function active(bool|Closure $active = true): static
    {
        $this->setActive($active);

        return $this;
    }

    /**
     * Set the active property quietly.
     */
    public function setActive(bool|Closure|null $active): void
    {
        if (is_null($active)) {
            return;
        }
        $this->active = $active;
    }

    /**
     * Alias for getActive
     */
    public function isActive(): bool
    {
        return $this->evaluate($this->active);
    }

    /**
     * Check if the class is not active
     */
    public function isNotActive(): bool
    {
        return ! $this->isActive();
    }
}
