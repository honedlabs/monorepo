<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Grid\Grid;

trait HasGrid
{
    /**
     * The grid.
     *
     * @var Grid|null
     */
    protected $grid;

    /**
     * Add a grid.
     *
     * @param  Grid|(Closure(Grid):Grid)|null  $value
     * @return $this
     */
    public function grid(Grid|Closure|null $value = null): static
    {
        $this->grid = match (true) {
            is_null($value) => $this->withGrid(),
            $value instanceof Closure => $value($this->withGrid()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the grid
     */
    public function getGrid(): ?Grid
    {
        return $this->grid;
    }

    /**
     * Create a new grid, or use the existing one.
     */
    protected function withGrid(): Grid
    {
        return $this->grid ??= Grid::make();
    }
}
