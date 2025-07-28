<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Axis\Axis;

trait HasAxes
{
    /**
     * The x-axes of the chart
     * 
     * @var array<int, \Honed\Chart\Axis\Axis>
     */
    protected $xAxis;

    /**
     * The y-axes of the chart
     * 
     * @var array<int, \Honed\Chart\Axis\Axis>
     */
    protected $yAxis;

    public function axis(Axis $axis): static
    {
        return $this;
    }
}