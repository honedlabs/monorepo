<?php

namespace Conquest\Core\Concerns;

/**
 * Set the visibility of the class
 */
trait IsHidden
{
    /** Classes by default are not hidden */
    protected bool $hidden = false;

    /**
     * Set the visibility of the class quietly.
     * 
     * @param bool $hidden
     * @return void
     */
    protected function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * Set the visibility of the column to hidden, chainable.
     * 
     * @return static
     */
    public function hide(): static
    {
        $this->setHidden(true);    
        return $this;
    }

    /**
     * Alias for hide
     * 
     * @return static
     */
    public function hidden(): static
    {
        return $this->hide();
    }

    /**
     * Set the visibility of the column to shown, chainable.
     * 
     * @return static
     */
    public function show(): static
    {
        $this->setShow(false);
        return $this;
    }

    /**
     * Alias for show
     * 
     * @return static
     */
    public function shown(): static
    {
        return $this->show();
    }

    /**
     * Check if the class is hidden.
     * 
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
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
