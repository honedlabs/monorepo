<?php

namespace Conquest\Chart;

use Conquest\Core\Primitive;

class Chart extends Primitive
{
    // Assume a charttype

    /**
     * Chart::make(data,
     *  type,
     *  yAxis: Axis
     *  xAxis: Axis
     *  title,
     *  tooltip,
     *  animation:
     * )
     */

    public function __construct()
    {
        parent::__construct();
    }

    public static function make(

    ): static {
        return resolve(static::class, func_get_args());
    }

    public function toArray(): array
    {
        return [
            'title' => '',
            'legend' => '',
            'xAxis' => '',
            'yAxis' => '',
            'series' => '',
            'tooltip' => '',
            'toolbox' => '',

        ];
    }
}
