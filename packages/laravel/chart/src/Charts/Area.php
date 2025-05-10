<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Area
{

    public function toArray()
    {
        return [
            'color',
            'curveType',
            'baseline',
            'opacity',
            'cursor',
            'minHeight1Px',
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