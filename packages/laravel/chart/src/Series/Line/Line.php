<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line;

use Honed\Chart\Concerns\HasAreaStyle;
use Honed\Chart\Concerns\HasLabelLine;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Concerns\HasColorBy;
use Honed\Chart\Series\Concerns\HasSampling;
use Honed\Chart\Series\Concerns\HasStack;
use Honed\Chart\Series\Concerns\HasStackOrder;
use Honed\Chart\Series\Concerns\HasStackStrategy;
use Honed\Chart\Series\Line\Concerns\CanBeSmooth;
use Honed\Chart\Series\Line\Concerns\CanConnectNulls;
use Honed\Chart\Series\Line\Concerns\HasCoordinateSystem;
use Honed\Chart\Series\Line\Concerns\HasSmoothMonotone;
use Honed\Chart\Series\Line\Concerns\HasStep;
use Honed\Chart\Series\Series;
use Honed\Chart\Support\Concerns\HasSymbol;
use Honed\Chart\Support\Concerns\HasSymbolSize;

class Line extends Series
{
    use CanBeSmooth;
    use CanConnectNulls;
    use HasAreaStyle;
    use HasColorBy;
    use HasCoordinateSystem;
    use HasLabelLine;
    use HasSampling;
    use HasSmoothMonotone;
    use HasStack;
    use HasStackOrder;
    use HasStackStrategy;

    // use HasSymbolRotate;
    use HasStep;
    use HasSymbol;
    use HasSymbolSize;

    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Line);
    }

    /**
     * Get the array representation of the line series.
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
            'symbol' => $this->getSymbol(),
            'symbolSize' => $this->getSymbolSize(),
            // 'symbolRotate' => $this->getSymbolRotate(),
            // 'symbolKeepAspect' => $this->isSymbolKeepAspect(),
            // 'showSymbol' => $this->isShowSymbol(),
            // 'showAllSymbol' => $this->isShowAllSymbol(),
            // 'legendHoverLink' => $this->isLegendHoverLink(),
            'stack' => $this->getStack(),
            'stackStrategy' => $this->getStackStrategy(),
            'stackOrder' => $this->getStackOrder(),
            'connectNulls' => $this->isNullConnected() ?: null,
            // 'triggerLineEvent' => $this->isTriggeringLineEvent(),
            'step' => $this->getStep() ?: null,
            // 'label' => $this->getLabel()?->toArray(),
            // 'endLabel' => $this->getEndLabel()?->toArray(),
            // 'labelLine' => $this->getLabelLine()?->toArray(),
            // 'labelLayout' => $this->getLabelLayout()?->toArray(),
            // 'itemStyle' => $this->getItemStyle()?->toArray(),
            'areaStyle' => $this->getAreaStyle()?->toArray(),
            // 'emphasis' => $this->getEmphasis()?->toArray(),
            // 'blur' => $this->getBlur()?->toArray(),
            // 'select' => $this->getSelect()?->toArray(),
            // 'selectedMode' => $this->getSelectedMode(),
            'smooth' => $this->isSmooth(),
            'smoothMonotone' => $this->getSmoothMonotone(),
            'sampling' => $this->getSampling(),
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
