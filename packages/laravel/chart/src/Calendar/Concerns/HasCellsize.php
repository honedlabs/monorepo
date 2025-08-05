<?php

declare(strict_types=1);

namespace Honed\Chart\Calendar\Concerns;

/**
 * @internal
 */
trait HasCellsize
{
    /**
     * The size of the calendar coordinates.
     * 
     * @var int|'auto'|array<int, int|'auto'>|null
     */
    protected $cellsize;

    /**
     * Set the size of the calendar coordinates.
     * 
     * @param int|'auto'|array<int, int|'auto'>|null $value
     * @return $this
     */
    public function cellsize(int|string|array $value): static
    {
        $this->cellsize = $value;

        return $this;
    }

    /**
     * Get the size of the calendar coordinates.
     * 
     * @return int|'auto'|array<int, int|'auto'>|null
     */
    public function getCellsize(): int|string|array|null
    {
        return $this->cellsize;
    }
}