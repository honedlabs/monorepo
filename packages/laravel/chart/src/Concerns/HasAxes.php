<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Axis\Axis;
use Honed\Chart\Axis\XAxis;
use Honed\Chart\Axis\YAxis;
use Illuminate\Support\Collection;

trait HasAxes
{
    /**
     * The axes.
     *
     * @var array<int, Axis>
     */
    protected $axes = [];

    /**
     * Add an axis to the chart.
     *
     * @return $this
     */
    public function axis(Axis $axis): static
    {
        $this->axes[] = $axis;

        return $this;
    }

    /**
     * Add axes to the chart.
     *
     * @param  Axis|array<int, Axis>|Collection<int, Axis>  $axes
     * @return $this
     */
    public function axes(Axis|array|Collection $axes): static
    {
        if ($axes instanceof Axis) {
            return $this->axis($axes);
        }
        if ($axes instanceof Collection) {
            $axes = $axes->all();
        }

        $this->axes = [...$this->axes, ...$axes];

        return $this;
    }

    /**
     * Get the axes.
     *
     * @return array<int, Axis>
     */
    public function getAxes(): array
    {
        return $this->axes;
    }

    /**
     * Get the x-axes.
     *
     * @return array<int, Axis>
     */
    public function getXAxes(): array
    {
        return $this->filteredAxes(Axis::X);
    }

    /**
     * Get the y-axes.
     *
     * @return array<int, Axis>
     */
    public function getYAxes(): array
    {
        return $this->filteredAxes(Axis::Y);
    }

    /**
     * Add a y-axis to the chart.
     *
     * @param  null|Axis|(Closure(Axis):mixed)  $value
     * @return $this
     */
    public function yAxis(YAxis|Closure|null $value = null): static
    {
        $axis = match (true) {
            is_null($value) => $this->newYAxis(),
            $value instanceof Closure => $value($this->newYAxis()),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Add an x-axis to the chart.
     *
     * @param  null|Axis|(Closure(Axis):mixed)  $value
     * @return $this
     */
    public function xAxis(Axis|Closure|null $value = null): static
    {
        $axis = match (true) {
            is_null($value) => $this->newXAxis(),
            $value instanceof Closure => $value($this->newXAxis()),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Get the x-axes representation.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getXAxesToArray(): array
    {
        $axes = $this->getXAxes();

        if (empty($axes)) {
            $axes = [$this->newXAxis()];
        }

        return array_map(
            static fn (XAxis $axis) => $axis->toArray(),
            $axes
        );
    }

    /**
     * Get the y-axes representation.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getYAxesToArray(): array
    {
        $axes = $this->getYAxes();

        if (empty($axes)) {
            $axes = [$this->newYAxis()];
        }

        return array_map(
            static fn (YAxis $axis) => $axis->toArray(),
            $axes
        );
    }

    /**
     * Get the filtered axes.
     *
     * @return array<int, Axis>
     */
    protected function filteredAxes(string $dimension): array
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
