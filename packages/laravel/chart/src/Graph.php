<?php

declare(strict_types=1);

namespace Honed\Chart;

class Graph
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