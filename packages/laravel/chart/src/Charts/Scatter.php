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
            'sizeRange',
            'labelHideOverlapping',
            'size',
            'duration',
            'label',
            'labelPosition',
            'labelTextBrightnessRatio',
            'labelPosition',
            'labelColor',
            'sizeRange',
            'strokeColor',
            'strokeWidth',
            'shape'
        ];
    }
}