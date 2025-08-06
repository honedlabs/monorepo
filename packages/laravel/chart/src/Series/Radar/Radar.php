<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Radar;

use Honed\Chart\Series\Series;
use Honed\Chart\Enums\ChartType;

use function PHPSTORM_META\map;

class Radar extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Radar);
    }

    /**
     * Get the array representation of the heatmap series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            // 'type',
            // 'id' => $this->getId(),
            // 'name' => $this->getName(),
            // 'colorBy',
            // 'radarIndex',
            // 'symbol',
            // 'symbolSize',
            // 'symbolRotate',
            // 'symbolKeepAspect',
            // 'symbolOffset',
            // 'label',
            // 'labelLayout',
            // 'itemStyle',
            // 'lineStyle',
            // 'areaStyle',
            // 'emphasis',
            // 'blur',
            // 'select',
            // 'selectedMode',
            // 'dataGroupId',
            // 'data',
            // 'zLevel',
            // 'z',
            // 'silent',
            // '...animation',
            // 'tooltip',
        ];
    }
}