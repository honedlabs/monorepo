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
     * Set the instance as visible.
     *
     * @return $this
     */
    public function visible(bool $visible = true): static
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Set the instance as invisible.
     *
     * @return $this
     */
    public function invisible(bool $invisible = true): static
    {
        return $this->visible(! $invisible);
    }

    /**
     * Determine if the instance is visible.
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }
}
