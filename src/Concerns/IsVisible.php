<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsVisible
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $visible = true;

    /**
     * Set as visible, chainable.
     * 
     * @param bool|\Closure():bool $visible
     * @return $this
     */
    public function visible(bool|\Closure $visible = true): static
    {
        $this->setVisible($visible);

        return $this;
    }

    /**
     * Set as invisible, chainable.
     * 
     * @param bool|\Closure():bool $visible
     * @return $this
     */
    public function invisible(bool|\Closure $visible = false): static
    {
        $this->setVisible($visible);

        return $this;
    }

    /**
     * Set the visibility property quietly.
     * 
     * @param bool|(\Closure():bool)|null $visible
     */
    public function setVisible(bool|\Closure|null $visible): void
    {
        if (is_null($visible)) {
            return;
        }
        $this->visible = $visible;
    }

    /**
     * Determine if the class is visible.
     */
    public function isVisible(): bool
    {
        return (bool) $this->evaluate($this->visible);
    }

    /**
     * Determine if the class is not visible.
     */
    public function isNotVisible(): bool
    {
        return ! $this->isVisible();
    }
}
