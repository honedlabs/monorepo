<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Concerns;

/**
 * @internal
 */
trait CanBeClipped
{
    /**
     * Whether to clip the overflow on the coordinate system.
     * 
     * @var bool
     */
    protected $clip = true;

    /**
     * Set whether to clip the overflow on the coordinate system.
     * 
     * @return $this
     */
    public function clip(bool $value = true): static
    {
        $this->clip = $value;

        return $this;
    }

    /**
     * Set whether to not clip the overflow on the coordinate system.
     * 
     * @return $this
     */
    public function dontClip(bool $value = true): static
    {
        return $this->clip(! $value);
    }

    /**
     * Get whether to clip the overflow on the coordinate system.
     */
    public function isClipped(): bool
    {
        return $this->clip;
    }

    /**
     * Get whether to not clip the overflow on the coordinate system.
     */
    public function isNotClipped(): bool
    {
        return ! $this->isClipped();
    }
}