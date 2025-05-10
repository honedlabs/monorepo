<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Series;
use Honed\Chart\Support\Constants;

class Bar extends Series
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Constants::BAR_CHART;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined(
            \array_merge(parent::toArray(), [
                'color',
                'groupWidth',
                'groupMaxWidth',
                'dataStep',
                'groupPadding',
            ])
        );
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