<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Line
{
    protected $thickness;

    protected $dashed;

    protected $curve;

    protected $fallback;

    protected $interpolate;

    public function toArray()
    {
        return [
            'color',
            'curveType',
            'lineWidth',
            'lineDashArray',
            'fallbackValue',
            'highlightOnHover',
            'interpolateMissingData',
            'duration',
        ];
    }
}