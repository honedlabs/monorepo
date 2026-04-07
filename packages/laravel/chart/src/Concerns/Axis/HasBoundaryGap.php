<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Axis;

trait HasBoundaryGap
{
    /**
     * The boundary gap.
     *
     * @var bool|array{0: int|float, 1: int|float}|null
     */
    protected bool|array|null $boundaryGap = null;

    /**
     * @param  bool|array{0: int|float, 1: int|float}  $value
     * @return $this
     */
    public function boundaryGap(bool|array $value): static
    {
        $this->boundaryGap = $value;

        return $this;
    }

    /**
     * Get the boundary gap.
     *
     * @return bool|array{0: int|float, 1: int|float}|null
     */
    public function getBoundaryGap(): bool|array|null
    {
        return $this->boundaryGap;
    }
}
