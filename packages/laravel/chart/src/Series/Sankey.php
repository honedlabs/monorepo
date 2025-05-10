<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Sankey
{
    public function toArray()
    {
        return [
            'heightNormalizationCoefficient',
            'exitTransitionType',
            'enterTransitionType',
            'highlightSubtreeOnHover',
            'highlightDuration',
            'highlightDelay',
            'iterations',
            
            'labelBackground',
            'labelFit',
            'labelTrimMode',
            'subLabel',
            'label',
            'subLabelPlacement',
            'nodeAlign',
            'nodeWidth',
            'nodePadding',
        ];
    }
}