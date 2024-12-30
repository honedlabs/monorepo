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
    public function invisible(bool $visible = false): static
    {
        $this->setVisible($visible);

        return $this;
    }

    /**
     * Set the visibility property quietly.
     */
    public function setVisible(bool|null $visible): void
    {
        if (\is_null($visible)) {
            return;
        }
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
