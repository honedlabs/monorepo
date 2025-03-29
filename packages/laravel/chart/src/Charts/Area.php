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
            'opacity',
            'minHeight1Px',
            'duration',
        ];
    }
}