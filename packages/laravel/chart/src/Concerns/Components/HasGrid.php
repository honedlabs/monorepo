<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Grid;

trait HasGrid
{
    /**
     * @var ?Grid
     */
    protected $gridInstance;

    /**
     * @param  Grid|(Closure(Grid):Grid)|bool|null  $value
     * @return $this
     */
    public function grid(Grid|Closure|bool|null $value = true): static
    {
        $this->gridInstance = match (true) {
            $value => $this->withGrid(),
            ! $value => null,
            $value instanceof Closure => $value($this->withGrid()),
            default => $value,
        };

        return $this;
    }

    public function getGrid(): ?Grid
    {
        return $this->gridInstance;
    }

    protected function withGrid(): Grid
    {
        return $this->gridInstance ??= Grid::make();
    }
}
