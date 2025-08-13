<?php

declare(strict_types=1);

namespace Honed\Chart\Label\Concerns;

trait CanHideOverlap
{
    /**
     * Whether to hide overlap.
     *
     * @var bool
     */
    protected $hideOverlap = false;

    /**
     * Set whether to hide overlap.
     *
     * @return $this
     */
    public function hideOverlap(bool $value = true): static
    {
        $this->hideOverlap = $value;

        return $this;
    }

    /**
     * Set whether to not hide overlap.
     *
     * @return $this
     */
    public function dontHideOverlap(bool $value = true): static
    {
        return $this->hideOverlap(! $value);
    }

    /**
     * Get whether to hide overlap.
     */
    public function isHidingOverlap(): bool
    {
        return $this->hideOverlap;
    }

    /**
     * Get whether to not hide overlap.
     */
    public function isNotHidingOverlap(): bool
    {
        return ! $this->isHidingOverlap();
    }
}
