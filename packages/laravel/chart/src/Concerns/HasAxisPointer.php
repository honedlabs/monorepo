<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\AxisPointer\AxisPointer;

trait HasAxisPointer
{
    /**
     * The axisPointer.
     * 
     * @var \Honed\Chart\AxisPointer\AxisPointer|null
     */
    protected $axisPointer;

    /**
     * Add a axisPointer.
     * 
     * @param \Honed\Chart\AxisPointer\AxisPointer|(Closure(\Honed\Chart\AxisPointer\AxisPointer):\Honed\Chart\AxisPointer\AxisPointer)|null $value
     * @return $this
     */
    public function axisPointer(AxisPointer|Closure|null $value = null): static
    {
        $this->axisPointer = match (true) {
            is_null($value) => $this->withAxisPointer(),
            $value instanceof Closure => $value($this->withAxisPointer()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the axisPointer
     * 
     * @return \Honed\Chart\AxisPointer\AxisPointer|null
     */
    public function getAxisPointer(): ?AxisPointer
    {
        return $this->axisPointer;
    }

    /**
     * Create a new axisPointer, or use the existing one.
     */
    protected function withAxisPointer(): AxisPointer
    {
        return $this->axisPointer ??= AxisPointer::make();
    }
}