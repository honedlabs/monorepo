<?php

declare(strict_types=1);

namespace Honed\Chart;

class Graph
{

    public function toArray()
    {
        return [
            'data' => [
                'nodes',
                'links',
            ]
        ];
    }
}