<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Bar
{
    public function toArray()
    {
        return [
            'color',
            'groupWidth',
            'groupMaxWidth',
            'dataStep',
            'groupPadding',
            'barPadding',
            'barMinHeight',
            'roundedCorners',
            'orientation',
            'id',
            'xScale',
            'yScale',
            'duration',

            'keys',
            'data',

            /**
             * StackedBar
             */
            'barWidth',
            'barMaxWidth',
        ];
    }
}