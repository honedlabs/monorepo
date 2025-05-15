<?php

declare(strict_types=1);

namespace Honed\Chart;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Exceptions\MissingDataException;

/**
 * @template TData of mixed = mixed
 */
class Chart extends ChartComponent
{
    use HasAnimationDuration;

    /**
     * The data of the chart.
     * 
     * @var iterable<int, TData>
     */
    protected $data = [];

    /**
     * The series of the chart.
     * 
     * @var array<int, \Honed\Chart\Series>
     */
    protected $series = [];

    /**
     * The domain of the chart.
     * 
     * @var array{int|float, int|float}
     */
    protected $domain;

    /**
     * The range of the chart.
     * 
     * @var array{int|float, int|float}
     */
    protected $range;

    /**
     * The legend of the chart.
     * 
     * @var \Honed\Chart\Legend|null
     */
    protected $legend;

    /**
     * The tooltip of the chart.
     * 
     * @var \Honed\Chart\Tooltip|null
     */
    protected $tooltip;

    /**
     * The colors to use for the chart series.
     */
    protected $colors;

    /**
     * Create a new chart instance.
     * 
     * @param iterable<int, TData> $data
     * @return static
     */
    public static function make($data = [])
    {
        return resolve(static::class)
            ->data($data);
    }

    /**
     * Set the data of the chart.
     * 
     * @param iterable<int, TData> $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Define the data of the chart.
     * 
     * @return iterable<int, TData>
     */
    public function defineData()
    {
        return [];
    }

    /**
     * Get the data of the chart.
     * 
     * @return iterable<int, TData>
     * 
     * @throws \Honed\Chart\Exceptions\MissingDataException
     */
    public function getData()
    {
        $this->data ??= $this->defineData();

        if (\is_null($this->data)) {
            MissingDataException::throw();
        }

        if ($this->data instanceof Collection) {
            $this->data = $this->data->all();
        }

        return $this->data;
    }

    /**
     * Set the series of the chart.
     * 
     * @param \Honed\Chart\Series|iterable<int, \Honed\Chart\Series> ...$series
     * @return $this
     */
    public function series(...$series)
    {
        $series = Arr::flatten($series);

        $this->series = \array_merge($this->series, $series);

        return $this;
    }

    /**
     * Define the series of the chart.
     * 
     * @return array<int, \Honed\Chart\Series>
     */
    public function defineSeries()
    {
        return [];
    }

    /**
     * Get the series of the chart.
     * 
     * @return array<int, \Honed\Chart\Series>
     */
    public function getSeries()
    {
        return \array_merge($this->defineSeries(), $this->series);
    }

    /**
     * Set the domain of the chart.
     * 
     * @param array{int|float, int|float} $domain
     * @return $this
     */
    public function domain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Define the domain of the chart.
     * 
     * @return array{int|float, int|float}
     */
    public function defineDomain()
    {
        return [];
    }

    /**
     * Get the domain of the chart.
     * 
     * @return array{int|float, int|float}|null
     */
    public function getDomain()
    {
        return $this->domain ??= $this->defineDomain() ?: null;
    }

    /**
     * Set the range of the chart.
     * 
     * @param array{int|float, int|float} $range
     * @return $this
     */
    public function range($range)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Define the range of the chart.
     * 
     * @return array{int|float, int|float}
     */
    public function defineRange()
    {
        return [];
    }

    /**
     * Get the range of the chart.
     * 
     * @return array{int|float, int|float}|null
     */
    public function getRange()
    {
        return $this->range ??= $this->defineRange() ?: null;
    }

    /**
     * Set the legend to be used for the chart.
     * 
     * @return $this
     */
    public function legend()
    {
        $this->legend = true;

        return $this;
    }

    /**
     * Define the legend to be used for the chart.
     * 
     * @return \Honed\Chart\Legend|null
     */
    public function defineLegend()
    {
        //
    }

    /**
     * Get the legend to be used for the chart.
     * 
     * @return \Honed\Chart\Legend|null
     */
    public function getLegend()
    {
        return $this->legend ??= $this->defineLegend();
    }

    /**
     * Set the tooltip to be used for the chart.
     * 
     * @return $this
     */
    public function tooltip()
    {
        $this->tooltip = true;

        return $this;
    }

    /**
     * Define the tooltip to be used for the chart.
     * 
     * @return \Honed\Chart\Tooltip|null
     */
    public function defineTooltip()
    {
        //
    }

    /**
     * Get the tooltip to be used for the chart.
     * 
     * @return \Honed\Chart\Tooltip|null
     */
    public function getTooltip()
    {
        return $this->tooltip ??= $this->defineTooltip();
    }

    /**
     * {@inheritDoc}
     */
    public static function flushState()
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function representation()
    {
        return [
            'data' => $this->getFilteredData(),
            'yDomain' => $this->getDomain(),
            'yDomain' => $this->getRange(),
            'series' => $this->seriesToArray(),
            'duration' => $this->getAnimationDuration(),
            'xAxis' => $this->getXAxis()?->toArray(),
            'yAxis' => $this->getYAxis()?->toArray(),
            'crosshair' => $this->getCrosshair()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            'legend' => $this->getLegend()?->toArray(),
            ...$this->animationDurationToArray()
        ];
    }
}