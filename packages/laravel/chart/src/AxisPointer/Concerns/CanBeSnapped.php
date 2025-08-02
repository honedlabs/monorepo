<?php

declare(strict_types=1);

namespace Honed\Chart\AxisPointer\Concerns;

trait CanBeSnapped
{
    /**
     * Whether to snap to point automatically.
     * 
     * @var bool|null
     */
    protected $snap;

    /**
     * Set whether to snap to point automatically.
     * 
     * @return $this
     */
    public function snap(bool $value = true): static
    {
        $this->snap = $value;

        return $this;
    }

    /**
     * Set whether to not snap to point automatically.
     * 
     * @return $this
     */
    public function dontSnap(bool $value = true): static
    {
        return $this->snap(!$value);
    }

    /**
     * Get whether to snap to point automatically.
     */
    public function isSnapped(): ?bool
    {
        return $this->snap;
    }

    /**
     * Get whether to not snap to point automatically.
     */
    public function isNotSnapped(): bool
    {
        return ! $this->isSnapped();
    }
}