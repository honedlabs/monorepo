<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Scatter;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;

class Scatter extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Scatter);
    }

    /**
     * Get the array representation of the scatter series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            // 'type',
            // 'id',
            // 'name',
            // 'colorBy',
            // 'coordinateSystem',
            'xAxisIndex',
            'yAxisIndex',
            'polarIndex',
            'geoIndex',
            'calendarIndex',
            'legendHoverLink',
            'symbol',
            'symbolSize',
            'symbolRotate',
            'symbolKeepAspect',
            'symbolOffset',
            'large',
            'largeThreshold',
            'cursor',
            'label',
            'labelLine',
            'labelLayout',
            'labelLayout',
            'itemStyle',
            'emphasis',
            'blur',
            'select',
            'selectedMode',
            'progressive',
            'progressiveThreshold',
            'dimensions',
            'encode',
            // 'seriesLayoutBy',
            // 'datasetIndex',
            // 'dimensions',
            // 'encode',
            // 'dataGroupId',
            // 'data',
            // 'markPoint',
            // 'markLine',
            // 'markArea',
            // 'clip',
            // 'zLevel',
            // 'z',
            // 'silent',
            // '...animation',
            // 'tooltip',
        ];
    }
}