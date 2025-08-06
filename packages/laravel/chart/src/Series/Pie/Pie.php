<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Pie;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;

use function PHPSTORM_META\map;

class Pie extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Pie);
    }

    /**
     * Get the array representation of the pie series.
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
            // 'geoIndex',
            // 'calendarIndex',
            // 'selectedMode',
            // 'selectedOffset',
            // 'clockwise',
            // 'startAngle',
            // 'endAngle',
            // 'minAngle',
            // 'padAngle',
            // 'minShowLabelAngle',
            // 'roseType',
            // 'avoidLabelOverlap',
            // 'stillShowZeroSum',
            // 'percentPrecision',
            // 'cursor',
            // 'zLevel',
            // 'z',
            // 'left',
            // 'top',
            // 'right',
            // 'bottom',
            // 'width',
            // 'height',
            // 'showEmptyCircle',
            // 'emptyCircleStyle',
            // 'label',
            // 'labelLine',
            // 'labelLayout',
            // 'itemStyle',
            // 'emphasis',
            // 'blur',
            // 'select',
            // 'center',
            // 'radius',
            // 'seriesLayoutBy',
            // 'datasetIndex',
            // 'dimensions',
            // 'encode',
            // 'dataGroupId',
            // 'data',
            // 'markPoint',
            // 'markLine',
            // 'markArea',
            // 'silent',
            // '...animation',
            // 'tooltip',
        ];
    }
}