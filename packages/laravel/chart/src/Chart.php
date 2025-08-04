<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\HasSeries;
use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Concerns\HasAxes;
use Honed\Chart\Concerns\HasLegend;
use Honed\Chart\Concerns\HasTitle;
use Honed\Chart\Concerns\HasToolbox;
use Honed\Chart\Concerns\CanBePolar;
use Honed\Chart\Concerns\HasAxisPointer;
use Honed\Chart\Concerns\HasGrid;
use Honed\Chart\Style\Concerns\HasBackgroundColor;

class Chart extends Primitive implements NullsAsUndefined
{
    use HasData;
    use HasSeries;
    use Animatable;
    use HasTextStyle;
    use HasTooltip;
    use HasLegend;
    use HasAxes;
    use CanBePolar;
    use HasToolbox;
    use HasTitle;
    use HasBackgroundColor;
    use HasGrid;
    use HasAxisPointer;

    /**
     * Create a new chart instance.
     */
    public static function make(mixed $data = null): static
    {
        return resolve(static::class)->data($data);
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
            'grid' => $this->getGrid()?->toArray(),
            'xAxis' => $this->getXAxesToArray(),
            'yAxis' => $this->getYAxesToArray(),
            'polar' => $this->getPolar()?->toArray(),
            // 'radiusAxis' => $this->getRadiusAxis()?->toArray(),
            // 'angleAxis' => $this->getAngleAxis()?->toArray(),
            // 'radar' => $this->getRadar()?->toArray(),
            // 'dataZoom' => $this->getDataZoom()?->toArray(),
            // 'visualMap' => $this->getVisualMap()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            'axisPointer' => $this->getAxisPointer()?->toArray(),
            'toolbox' => $this->getToolbox()?->toArray(),
            // 'timeline' => $this->getTimeline()?->toArray(),
            // 'calendar' => $this->getCalendar()?->toArray(),
            'series' => $this->seriesToArray(),
            // 'color' => $this->getColor(),
            'backgroundColor' => $this->getBackgroundColor(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            ...$this->getAnimationParameters(),
        ];
    }
}