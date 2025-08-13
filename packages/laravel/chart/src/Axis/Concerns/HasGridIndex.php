<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait HasGridIndex
{
    /**
     * The index of the grid to which the axis belongs.
     *
     * @var int|null
     */
    protected $gridIndex;

    /**
     * Set the index of the grid to which the axis belongs.
     *
     * @return $this
     */
    public function gridIndex(int $value): static
    {
        $this->gridIndex = $value;

        return $this;
    }

    /**
     * Get the index of the grid to which the axis belongs.
     */
    public function getGridIndex(): ?int
    {
        return $this->gridIndex;
    }
}
