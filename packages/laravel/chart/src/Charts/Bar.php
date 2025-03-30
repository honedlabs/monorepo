<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Bar
{
    public function toArray()
    {
        return [
            'color',
            'roundedCorners',
            'groupWidth',
            'groupMaxWidth',
            'groupPadding',
            'barPadding',
            'barMinHeight',
            'dataStep',
            'orientation'

            /**
             * StackedBar
             */
            'barWidth',
            'barMaxWidth',
        ];
    }
}