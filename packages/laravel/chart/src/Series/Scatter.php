<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasStroke;
use Honed\Chart\Series;
use Honed\Chart\Support\Constants;

class Scatter extends Series
{
    use HasColor;
    use HasStroke;
    use ExcludesFromDomainCalculation;

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return Constants::SCATTER_CHART;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined(
            \array_merge(parent::toArray(), [
                'color' => $this->getColor(),
                'size' => $this->getSize(),
                // ...$this->shapeToArray(),
                // 'sizeScale',
                // 'sizeRange',
                'shape' => $this->getShape(),
                'label',
                'labelColor',
                'labelHideOverlapping',
                'labelTextBrightnessRatio',
                'labelPosition',
                ...$this->strokeToArray(),
                ...$this->excludeFromDomainToArray(),
                ...$this->animationDurationToArray(),

            ])
        );
        // return [
        //     'color',
        //     'size',
        //     'sizeScale',
        //     'sizeRange',
        //     'shape',
        //     'label',
        //     'labelColor',
        //     'labelHideOverlapping',
        //     'cursor',
        //     'labelTextBrightnessRatio',
        //     'labelPosition',
        //     'strokeColor',
        //     'strokeWidth',
        //     'id',
        //     'xScale',
        //     'yScale',
        //     'excludeFromDomainCalculation',
        //     'duration',

        //     'keys',
        //     'data'
        // ];
    }
}