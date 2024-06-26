<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set whether a class is the default
 */
trait IsDefault
{
    protected bool|Closure $default = false;

    /**
     * Set the class as default, chainable
     * 
     * @param bool|Closure $default
     * @return static
     */
    public function default(bool|Closure $default = true): static
    {
        $this->setDefault($default);
        return $this;
    }

    /**
     * Set the default quietly
     * 
     * @param bool|Closure $default
     */
    protected function setDefault(bool|Closure $default): void
    {
        if (is_null($default)) return;
        $this->default = $default;
    }

    /**
     * Alias for getDefault
     * 
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->getDefault();
    }

    /**
     * Get if the class is default
     * 
     * @return bool
     */
    public function getDefault(): bool
    {
        return $this->evaluate($this->default);
    }
}