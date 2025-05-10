<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Scatter
{

    public function toArray()
    {
        return [
            'color',
            'size',
            'sizeScale',
            'sizeRange',
            'shape',
            'label',
            'labelColor',
            'labelHideOverlapping',
            'cursor',
            'labelTextBrightnessRatio',
            'labelPosition',
            'strokeColor',
            'strokeWidth',
            'id',
            'xScale',
            'yScale',
            'excludeFromDomainCalculation',
            'duration',

            'keys',
            'data'
        ];
    }
}