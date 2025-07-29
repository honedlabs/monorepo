<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Axis\Axis;
use Honed\Chart\Axis\XAxis;
use Honed\Chart\Axis\YAxis;
use InvalidArgumentException;

trait HasAxes
{
    /**
     * The x-axes of the chart
     * 
     * @var \Honed\Chart\Axis\XAxis|null
     */
    protected $x = [];

    /**
     * The y-axes of the chart
     * 
     * @var \Honed\Chart\Axis\YAxis|null
     */
    protected $y = [];

    /**
     * Add an axis to the chart.
     * 
     * @return $this
     */
    public function axis(Axis $axis): static
    {
        match (true) {
            $axis instanceof XAxis => $this->xAxis($axis),
            $axis instanceof YAxis => $this->yAxis($axis),
            default => throw new InvalidArgumentException(
                sprintf("Invalid axis type: %s", get_class($axis))
            ),
        };

        return $this;
    }

    /**
     * Add an x-axis to the chart.
     * 
     * @param \Honed\Chart\Axis\XAxis|(Closure(\Honed\Chart\Axis\XAxis):mixed)|null $value
     * @return $this
     */
    public function xAxis(XAxis|Closure|null $value): static
    {
        return match (true) {
            is_null($value) => $this->newXAxis(),
            $value instanceof Closure => $value($this->newXAxis()),
            default => $this->x = $value,
        };
    }

    /**
     * Add a y-axis to the chart.
     * 
     * @param \Honed\Chart\Axis\YAxis|(Closure(\Honed\Chart\Axis\YAxis):mixed)|null $value
     * @return $this
     */
    public function yAxis(YAxis|Closure|null $value): static
    {
        return match (true) {
            is_null($value) => $this->newYAxis(),
            $value instanceof Closure => $value($this->newYAxis()),
            default => $this->y = $value,
        };

        return $this;
    }

    /**
     * Get the x-axes of the chart.
     * 
     * @return \Honed\Chart\Axis\XAxis|null
     */
    public function getXAxis(): ?XAxis
    {
        return $this->x;
    }

    /**
     * Get the y-axes of the chart.
     * 
     * @return \Honed\Chart\Axis\YAxis|null
     */
    public function getYAxis(): ?YAxis
    {
        return $this->y;
    }

    /**
     * Create a new x-axis, or use the existing one.
     */
    protected function newXAxis(): XAxis
    {
        return $this->x ??= XAxis::make();
    }

    /**
     * Create a new y-axis, or use the existing one.
     */
    protected function newYAxis(): YAxis
    {
        return $this->y ??= YAxis::make();
    }

}