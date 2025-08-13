<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Bar;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;

class Bar extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Bar);
    }

    /**
     * Get the array representation of the bar series.
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
            // 'legendHoverLink',
            // 'coordinateSystem',
            // 'xAxisIndex',
            // 'yAxisIndex',
            // 'polarIndex',
            // 'roundCap',
            // 'realtimeSort',
            // 'showBackground',
            // 'backgroundStyle',
            // 'label',
            // 'labelLine',
            // 'itemStyle',
            // 'labelLayout',
            // 'emphasis',
            // 'blur',
            // 'select',
            // 'selectedMode',
            // 'stack',
            // 'stackStrategy',
            // 'stackOrder',
            // 'sampling',
            // 'cursor',
            // 'barWidth',
            // 'barMaxWidth',
            // 'barMinWidth',
            // 'barMinHeight',
            // 'barMinAngle',
            // 'barGap',
            // 'barCategoryGap',
            // 'large',
            // 'progressive',
            // 'progressiveThreshold',
            // 'progressiveChunkMode',
            // 'dimensions',
            // 'encode',
            // 'seriesLayoutBy',
            // 'datasetIndex',
            // 'dataGroupId',
            // 'data',
            // 'clip',
            // 'markPoint',
            // 'markLine',
            // 'markArea',
            // 'zLevel',
            // 'z',
            // 'silent',
            // '...animation',
        ];
    }
}
