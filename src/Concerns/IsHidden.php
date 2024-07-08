<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set the visibility of the class
 */
trait IsHidden
{
    /** Classes by default are not hidden */
    protected bool|Closure $hidden = false;

    /**
     * Alias for hide
     * 
     * @return static
     */
    public function hidden(bool|Closure $hidden = true): static
    {
        $this->setHidden($hidden);    
        return $this;
    }

    /**
     * Set the visibility of the class quietly.
     * 
     * @param bool $hidden
     * @return void
     */
    public function setHidden(bool|Closure $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * Set the visibility of to hidden, chainable.
     * 
     * @return static
     */
    public function hide(): static
    {
        return $this->hidden(true);
    }


    /**
     * Set the visibility to shown, chainable.
     * 
     * @return static
     */
    public function show(): static
    {
        return $this->hidden(false);
    }

    /**
     * Check if the class is hidden.
     * 
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->evaluate($this->hidden);
    }

    /**
     * Check if the class is shown.
     * 
     * @return bool
     */
    public function isShown(): bool
    {
        return !$this->isHidden();
    }

}
