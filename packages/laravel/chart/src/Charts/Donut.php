<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Donut
{
    public function toArray()
    {
        return [
            'value',
            'centralLabel',
            'centralSubLabel',
            'angleRange',
            'radius',
            'arcWidth',
            'color',
            'cornerRadius',
            'padAngle',
            'showEmptySegments',
            'showBackground',
            'duration',
        ];
    }
}