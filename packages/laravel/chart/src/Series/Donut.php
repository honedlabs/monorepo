<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Donut
{
    public function toArray()
    {
        return [
            'value',
            'id',
            'angleRange',
            'padAngle',
            'cornerRadiys',
            'color',
            'radius',
            'arcWidth',
            'centralLabel',
            'centralSubLabel',
            'centralSubLabelWrap',
            'showEmptySegments',
            'emptySegmentAngle',
            'showBackground',
            'backgroundAngleRange',
            'centralLabelOffsetX',
            'centralLabelOffsetY',
            'duration',

            'keys',
            'data'
        ];
    }
}