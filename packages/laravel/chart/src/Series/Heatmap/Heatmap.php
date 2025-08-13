<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Heatmap;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;

class Heatmap extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Heatmap);
    }

    /**
     * Get the array representation of the heatmap series.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => 'heatmap',
            'id' => $this->getId(),
            'name' => $this->getName(),
            // 'coordinateSystem' => $this->getCoordinateSystem(),
            // 'xAxisIndex' => $this->getXAxisIndex(),
            // 'yAxisIndex' => $this->getYAxisIndex(),
            // 'geoIndex' => $this->getZAxisIndex(),
            // 'calendarIndex' => $this->getZAxisIndex(),
            // 'pointSize' => $this->getPointSize(),
            // 'blurSize' => $this->getBlurSize(),
            // 'minOpacity' => $this->getMinOpacity(),
            // 'maxOpacity' => $this->getMaxOpacity(),
            // 'progressive' => $this->getProgressive(),
            // 'progressiveThreshold' => $this->getProgressiveThreshold(),
            // 'label' => $this->getLabel()?->toArray(),
            // 'labelLayout',
            // 'itemStyle',
            // 'emphasis',
            // 'blur',
            // 'select',
            // 'selectedMode',
            // 'encode',
            // 'seriesLayoutBy',
            // 'datasetIndex',
            // 'dataGroupId',
            // 'data',
            // 'markPoint',
            // 'markLine',
            // 'markArea',
            // 'zLevel',
            // 'z',
            // 'silent',
            // 'tooltip',
        ];
    }
}
