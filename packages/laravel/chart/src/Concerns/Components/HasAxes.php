<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Axis;
use Honed\Chart\XAxis;
use Honed\Chart\YAxis;
use Honed\Chart\Enums\Dimension;
use Illuminate\Support\Enumerable;

trait HasAxes
{
    /**
     * The axes.
     *
     * @var list<Axis>
     */
    protected $axes = [];

    /**
     * Add an axis to the chart.
     *
     * @return $this
     */
    public function axis(?Axis $axis): static
    {
        if ($axis) {
            $this->axes[] = $axis;
        }

        return $this;
    }

    /**
     * Add axes to the chart.
     *
     * @param  Axis|array<int, Axis>|Enumerable<int, Axis>  $axes
     * @return $this
     */
    public function axes(Axis|array|Enumerable $axes): static
    {
        if ($axes instanceof Axis) {
            return $this->axis($axes);
        }

        if ($axes instanceof Enumerable) {
            /** @var list<Axis> */
            $axes = $axes->all();
        }

        $this->axes = [...$this->axes, ...$axes];

        return $this;
    }

    /**
     * Get the axes.
     *
     * @return list<Axis>
     */
    public function getAxes(): array
    {
        return $this->axes;
    }

    /**
     * Get the x-axes.
     *
     * @return list<Axis>
     */
    public function getXAxes(): array
    {
        return $this->filteredAxes(Dimension::X);
    }

    /**
     * Get the y-axes.
     *
     * @return list<Axis>
     */
    public function getYAxes(): array
    {
        return $this->filteredAxes(Dimension::Y);
    }

    /**
     * Add a y-axis to the chart.
     *
     * @param  Axis|(Closure(Axis):Axis)|bool|null  $value
     * @return $this
     */
    public function yAxis(Axis|Closure|bool|null $value = true): static
    {
        $axis = match (true) {
            $value => $this->newYAxis(),
            ! $value => null,
            $value instanceof Closure => $value($this->newYAxis()),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Add an x-axis to the chart.
     *
     * @param  Axis|(Closure(Axis):Axis)|bool|null  $value
     * @return $this
     */
    public function xAxis(Axis|Closure|bool|null $value = true): static
    {
        $axis = match (true) {
            $value => $this->newXAxis(),
            ! $value => null,
            $value instanceof Closure => $value($this->newXAxis()),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Get the x-axes representation.
     *
     * @return list<array<string, mixed>>
     */
    public function getXAxesToArray(): array
    {
        $axes = $this->getXAxes();

        if (empty($axes)) {
            $axes = [$this->newXAxis()];
        }

        return array_map(
            static fn (Axis $axis) => $axis->toArray(),
            $axes
        );
    }

    /**
     * Get the y-axes representation.
     *
     * @return list<array<string, mixed>>
     */
    public function getYAxesToArray(): array
    {
        $axes = $this->getYAxes();

        if (empty($axes)) {
            $axes = [$this->newYAxis()];
        }

        return array_map(
            static fn (Axis $axis) => $axis->toArray(),
            $axes
        );
    }

    /**
     * Get the filtered axes.
     *
     * @return list<Axis>
     */
    protected function filteredAxes(Dimension $dimension): array
    {
        return array_values(
            array_filter(
                $this->axes,
                static fn (Axis $axis) => $axis->getDimension() === $dimension
            )
        );
    }

    /**
     * Create a new x-axis, or use the existing one.
     */
    protected function newXAxis(): XAxis
    {
        return XAxis::make();
    }

    /**
     * Create a new y-axis, or use the existing one.
     */
    protected function newYAxis(): YAxis
    {
        return YAxis::make();
    }
}
