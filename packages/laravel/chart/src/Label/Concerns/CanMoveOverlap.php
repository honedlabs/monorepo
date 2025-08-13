<?php

declare(strict_types=1);

namespace Honed\Chart\Label\Concerns;

use Honed\Chart\Enums\OverlapShift;

trait CanMoveOverlap
{
    /**
     * The configuration for moving overlaps.
     *
     * @var string|null
     */
    protected $moveOverlap;

    /**
     * Set the configuration for moving overlaps.
     *
     * @return $this
     */
    public function moveOverlap(string|OverlapShift $value): static
    {
        $this->moveOverlap = is_string($value) ? $value : $value->value;

        return $this;
    }

    /**
     * Set the configuration for moving overlaps to shift the x-axis.
     *
     * @return $this
     */
    public function moveOverlapX(): static
    {
        return $this->moveOverlap(OverlapShift::X);
    }

    /**
     * Set the configuration for moving overlaps to shift the y-axis.
     *
     * @return $this
     */
    public function moveOverlapY(): static
    {
        return $this->moveOverlap(OverlapShift::Y);
    }

    /**
     * Get the configuration for moving overlaps.
     */
    public function getMoveOverlap(): ?string
    {
        return $this->moveOverlap;
    }
}
