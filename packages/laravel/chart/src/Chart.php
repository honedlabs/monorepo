<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @template TData of mixed = mixed
 */
class Chart extends Primitive
{
    use HasAnimationDuration;

    /**
     * The series of the chart.
     * 
     * @var array<int, \Honed\Chart\Series>
     */
    protected $series = [];

    /**
     * The data of the chart.
     * 
     * @var iterable<int, TData>
     */
    protected $data = [];

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
     * Set the dependent data of the chart.
     */
    public function dependent()
    {

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

    // Legend

    public function legend()
    {
        $this->legend = true;

        return $this;
    }

    public function defineLegend()
    {
        return true;
    }

    public function getLegend()
    {
        return $this->legend;
    }

    // Tooltip

    public function tooltip()
    {
        $this->tooltip = true;

        return $this;
    }

    public function defineTooltip()
    {
        return true;
    }

    public function getTooltip()
    {
        
    }
    
    

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'data' => $this->getFilteredData(),
            'series' => $this->seriesToArray(),
            'tooltip' => $this->getTooltip(),
            'duration' => $this->getAnimationDuration(),
        ];
    }
}