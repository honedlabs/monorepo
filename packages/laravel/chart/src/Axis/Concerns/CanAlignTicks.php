<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait CanAlignTicks
{
    /**
     * Whether to automatically align ticks when there are multiple axes.
     * 
     * @var bool|null
     */
    protected $alignTicks;

    /**
     * Set whether to automatically align ticks when there are multiple axes.
     * 
     * @param bool $value
     * @return $this
     */
    public function alignTicks(bool $value = true): static
    {
        $this->alignTicks = $value;

        return $this;
    }

    /**
     * Get whether to automatically align ticks when there are multiple axes.
     * 
     * @return true|null
     */
    public function hasAlignedTicks(): ?bool
    {
        return $this->alignTicks ?: null;
    }
}