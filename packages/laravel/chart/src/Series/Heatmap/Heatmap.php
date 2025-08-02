<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Heatmap;

use Honed\Chart\Series\Series;

class Heatmap extends Series
{
    protected function representation(): array
    {
        return [
            'type' => 'heatmap',
            'id' => $this->getId(),
            // 'name' => $this->getName(),
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
        ];
    }
}