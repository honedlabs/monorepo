<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Series;
use Honed\Chart\Support\Constants;

class Pie extends Series
{
    /**
     * The radius of the pie chart.
     * 
     * @var int|null
     */
    protected $radius;

    /**
     * The default radius of the pie chart.
     * 
     * @var int|null
     */
    protected static $defaultRadius;

    /**
     * The arc width of the chart to create a donut.
     * 
     * @var int|null
     */
    protected $arcWidth;

    /**
     * The default arc width of the chart to create a donut.
     * 
     * @var int|null
     */
    protected static $defaultArcWidth;

    /**
     * The angle range of the pie chart to create a partial pie chart.
     * 
     * @var array{int|float, int|float}|null
     */
    protected $angleRange;

    /**
     * The default angle range of the pie chart to create a partial pie chart.
     * 
     * @var array{int|float, int|float}|null
     */
    protected static $defaultAngleRange;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Constants::PIE_CHART;
    }
}