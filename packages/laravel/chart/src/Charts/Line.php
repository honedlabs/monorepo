<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasLines;

class Line
{
    use HasColor;
    use HasAnimationDuration;
    use HasLines;

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
            'cursor',
            'interpolateMissingData',
            'id',
            'xScale',
            'yScale',
            'duration',

            'keys',
            'data'
        ];
    }
}