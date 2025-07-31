<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Line\Concerns\CanBeSmooth;
use Honed\Chart\Series\Line\Concerns\CanColorBy;
use Honed\Chart\Series\Line\Concerns\HasCoordinateSystem;
use Honed\Chart\Series\Series;

class Line extends Series
{
    use CanBeSmooth;
    use HasCoordinateSystem;
    use CanColorBy;

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Line);
    }

    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'colorBy' => $this->getColorBy(),
            // 'legendHoverLink' => $this->isLegendHoverLink(),
            'coordinateSystem' => $this->getCoordinateSystem(),
            // 'xAxisIndex' => $this->getXAxisIndex(),
            // 'yAxisIndex' => $this->getYAxisIndex(),
            // 'polarIndex' => $this->getPolarIndex(),
            // 'symbol' => $this->getSymbol(),
            // 'symbolSize' => $this->getSymbolSize(),
            // 'symbolRotate' => $this->getSymbolRotate(),
            // 'symbolKeepAspect' => $this->isSymbolKeepAspect(),
            // 'showSymbol' => $this->isShowSymbol(),
            // 'showAllSymbol' => $this->isShowAllSymbol(),
            // 'legendHoverLink' => $this->isLegendHoverLink(),
            // 'stack' => $this->getStack(),
            // 'stackStrategy' => $this->getStackStrategy(),
            // 'stackOrder' => $this->getStackOrder(),
            // 'cursor' => $this->getCursor(),
            // 'connectNulls' => $this->isConnectingNulls(),
            // 'clip' => $this->isClipped(),
            // 'triggerLineEvent' => $this->isTriggeringLineEvent(),
            // 'step' => $this->isStep(),
            // 'label' => $this->getLabel()?->toArray(),
            // 'endLabel' => $this->getEndLabel()?->toArray(),
            // 'labelLine' => $this->getLabelLine()?->toArray(),
            // 'labelLayout' => $this->getLabelLayout()?->toArray(),
            // 'itemStyle' => $this->getItemStyle()?->toArray(),
            // 'areaStyle' => $this->getAreaStyle()?->toArray(),
            // 'emphasis' => $this->getEmphasis()?->toArray(),
            // 'blur' => $this->getBlur()?->toArray(),
            // 'select' => $this->getSelect()?->toArray(),
            // 'selectedMode' => $this->getSelectedMode(),
            // 'smooth' => $this->isSmooth(),
            // 'smoothMonotone' => $this->isSmoothMonotone(),
            // 'sampling' => $this->getSampling(),
            // 'dimensions',
            // 'encode' => $this->getEncode()?->toArray(),
            // 'seriesLayoutBy' => $this->getSeriesLayoutBy(),
            // 'markPoint' => $this->getMarkPoint()?->toArray(),
            // 'markLine' => $this->getMarkLine()?->toArray(),
            // 'markArea' => $this->getMarkArea()?->toArray(),
            // 'tooltip' => $this->getTooltip()?->toArray(),
        ];
    }

}