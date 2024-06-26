<?php

namespace Vanguard\Core\Concerns;

/**
 * Set the visibility of the class
 */
trait HasDisplay
{
    /** Classes by default are shown */
    protected bool $show = true;

    /**
     * Set the visibility of the class quietly.
     * 
     * @param bool $show
     * @return void
     */
    protected function setShow(bool $show): void
    {
        $this->show = $show;
    }

    /**
     * Set the visibility of the column to hidden, chainable.
     * 
     * @return static
     */
    public function hide(): static
    {
        $this->setShow(false);    
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
     * Alias for hide
     * 
     * @return static
     */
    public function dontDisplay(): static
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
        $this->setShow(true);
        return $this;
    }

    /**
     * Alias for show
     * 
     * @return static
     */
    public function shown(): static
    {
        return $this->show(true);
    }

    /**
     * Set the visibility of the column to shown, chainable.
     * 
     * @param bool $condition
     * @return static
     */
    public function display(bool $condition = true): static
    {
        return $this->show($condition);
    }

    /**
     * Check if the class is shown.
     * 
     * @return bool
     */
    public function isShown(): bool
    {
        return $this->show;
    }

    /**
     * Check if the class is hidden.
     * 
     * @return bool
     */
    public function isHidden(): bool
    {
        return !$this->isShown();
    }
}
