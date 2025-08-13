<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasBoundaryGap
{
    /**
     * The boundary gap on both sides of a coordinate axis.
     *
     * @var bool|array<int, bool>|null
     */
    protected $boundaryGap;

    /**
     * Set the boundary gap on both sides of a coordinate axis.
     *
     * @param  bool|array<int, string>  $value
     */
    public function boundaryGap(bool|array $value = true): static
    {
        $this->boundaryGap = $value;

        return $this;
    }

    /**
     * Get the boundary gap on both sides of a coordinate axis.
     *
     * @return bool|array<int, string>|null
     */
    public function getBoundaryGap(): bool|array|null
    {
        return $this->boundaryGap;
    }
}
