<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

class Sankey
{
    public function toArray()
    {
        return [
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