<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Components\HasAxes;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\Components\HasLegend;
use Honed\Chart\Concerns\Components\HasSeries;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\Components\HasTitle;
use Honed\Chart\Concerns\Components\HasToolbox;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @property-read \Honed\Chart\Legend $legend
 * @property-read \Honed\Chart\Title $title
 * @property-read \Honed\Chart\Tooltip $tooltip
 * @property-read \Honed\Chart\Toolbox $toolbox
 * @property-read \Honed\Chart\TextStyle $textStyle
 */
class Chart extends Chartable
{
    use ForwardsCalls;
    use HasAxes;
    use HasData;
    use HasLegend;
    use HasSeries;
    use HasTextStyle;
    use HasTitle;
    use HasToolbox;
    use HasTooltip;
    use InteractsWithData;

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array<int,mixed>  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        return match ($method) {
            'legend' => $this->forwardCallTo($this->withLegend(), $method, $parameters),
            'title' => $this->forwardCallTo($this->withTitle(), $method, $parameters),
            'tooltip' => $this->forwardCallTo($this->withTooltip(), $method, $parameters),
            'toolbox' => $this->forwardCallTo($this->withToolbox(), $method, $parameters),
            'textStyle' => $this->forwardCallTo($this->withTextStyle(), $method, $parameters),
            default => parent::__call($method, $parameters),
        };
    }

    /**
     * Resolve the data into the components.
     */
    protected function resolve(): void
    {
        foreach ($this->getAxes() as $axis) {
            $axis->resolve($this->getData());
        }

        foreach ($this->getSeries() as $series) {
            $series->resolve($this->getData());
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function representation(): array
    {
        $this->define();

        $this->resolve();

        return [
            'title' => $this->getTitle()?->toArray(),
            'legend' => $this->getLegend()?->toArray(),
            // 'grid' => $this->getGrid()?->toArray(),
            'xAxis' => $this->getXAxesToArray(),
            'yAxis' => $this->getYAxesToArray(),
            // 'radiusAxis' => $this->getRadiusAxis()?->toArray(),
            // 'angleAxis' => $this->getAngleAxis()?->toArray(),
            // 'radar' => $this->getRadar()?->toArray(),
            // 'dataZoom' => $this->getDataZoom()?->toArray(),
            // 'visualMap' => $this->getVisualMap()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            // 'axisPointer' => $this->getAxisPointer()?->toArray(),
            'toolbox' => $this->getToolbox()?->toArray(),
            // 'timeline' => $this->getTimeline()?->toArray(),
            // 'calendar' => $this->getCalendar()?->toArray(),
            'series' => $this->seriesToArray(),
            // 'color' => $this->getColor(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
