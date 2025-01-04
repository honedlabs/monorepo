<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsVisible
{
    /**
     * @var bool
     */
    protected $visible = true;

    /**
     * Set as visible, chainable.
     *
     * @return $this
     */
    public function visible(bool $visible = true): static
    {
        $this->setVisible($visible);

        return $this;
    }

    /**
     * Set as invisible, chainable.
     *
     * @return $this
     */
    public function invisible(bool $invisible = true): static
    {
        return $this->visible(! $invisible);
    }

    /**
     * Set the visibility property quietly.
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * Determine if it is visible.
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }
}
