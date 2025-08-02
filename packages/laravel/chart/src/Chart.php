<?php

declare(strict_types=1);

namespace Honed\Chart;

use RuntimeException;
use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Honed\Chart\Concerns\HasData;
use Illuminate\Support\Collection;
use Honed\Chart\Concerns\HasSeries;
use Honed\Chart\Concerns\Animatable;
use Honed\Chart\Concerns\HasTooltip;
use Honed\Chart\Concerns\HasTextStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasAxes;
use Honed\Chart\Concerns\HasLegend;
use Honed\Chart\Concerns\HasTitle;
use Honed\Chart\Concerns\HasToolbox;
use Honed\Chart\Exceptions\MissingDataException;
use Honed\Chart\Concerns\CanBePolar;
use Honed\Chart\Style\Concerns\HasBackgroundColor;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\ForwardsCalls;
use Pest\Factories\Concerns\HigherOrderable;

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
            'xAxis' => $this->getXAxesToArray(),
            'yAxis' => $this->getYAxesToArray(),
            'polar' => $this->getPolar()?->toArray(),
            'tooltip' => $this->getTooltip()?->toArray(),
            'toolbox' => $this->getToolbox()?->toArray(),
            'series' => $this->seriesToArray(),
            'textStyle' => $this->getTextStyle()?->toArray(),
            'backgroundColor' => $this->getBackgroundColor(),
            ...$this->getAnimationParameters(),
        ];
    }
}