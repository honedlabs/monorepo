<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait HasNameGap
{
    /**
     * The gap between the axis name and the axis line.
     * 
     * @var int|null
     */
    protected $nameGap;

    /**
     * Set the gap between the axis name and the axis line.
     * 
     * @return $this
     */
    public function nameGap(int $value): static
    {
        $this->nameGap = $value;

        return $this;
    }

    /**
     * Get the gap between the axis name and the axis line.
     */
    public function getNameGap(): ?int
    {
        return $this->nameGap;
    }
}