<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsVisible
{
    /**
     * @var bool
     */
    protected $invisible = false;

    /**
     * Set as visible, chainable.
     *
     * @return $this
     */
    public function visible(bool $visible = true): static
    {
        $this->setInvisible($visible);

        return $this;
    }

    /**
     * Set as invisible, chainable.
     *
     * @return $this
     */
    public function invisible(bool $invisible = true): static
    {
        $this->setInvisible(! $invisible);

        return $this;
    }

    /**
     * Set the visibility property quietly.
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * Determine if the class is visible.
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }
}
