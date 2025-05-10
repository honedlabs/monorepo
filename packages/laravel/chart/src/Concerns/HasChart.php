<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Chart;
use Honed\Chart\Attributes\Chart as ChartAttribute;

/**
 * @template TChart of \Honed\Chart\Chart = \Honed\Chart\Chart
 *
 * @property string $chart
 */
trait HasChart
{
    /**
     * Get the action group instance for the model.
     *
     * @return TChart
     */
    public static function chart()
    {
        return static::newChart()
            ?? Chart::chartForModel(static::class);
    }

    /**
     * Create a new action group instance for the model.
     *
     * @return TChart
     */
    protected static function newChart()
    {
        if (isset(static::$chart)) {
            return static::$chart::make();
        }

        if ($chart = static::getChartAttribute()) {
            return $chart::make();
        }

        return null;
    }

    /**
     * Get the chart from the Chart class attribute.
     *
     * @return class-string<TChart>|null
     */
    protected static function getChartAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(ChartAttribute::class);

        if ($attributes !== []) {
            $chart = $attributes[0]->newInstance();

            return $chart->chart;
        }

        return null;
    }
}
