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
     * 
     * @param bool|Closure $active
     * @return static
     */
    public function active(bool|Closure $active): static
    {
        $this->setActive($active);
        return $this;
    }

    /**
     * Set the active property quietly.
     * 
     * @param bool|Closure $active
     * @return void
     */
    public function setActive(bool|Closure|null $active): void
    {
        if (is_null($active)) return;
        $this->active = $active;
    }

    /**
     * Alias for getActive
     * 
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getActive();
    }

    /**
     * Check if the class is active
     * 
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->evaluate($this->active);
    }
}