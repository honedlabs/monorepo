<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Components\HasAxes;
use Honed\Chart\Concerns\Components\HasLegend;
use Honed\Chart\Concerns\Components\HasSeries;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\Components\HasTitle;
use Honed\Chart\Concerns\Components\HasToolbox;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Concerns\Support\Inferrable;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\Dimension;
use Honed\Chart\Proxies\HigherOrderTooltip;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @property-read HigherOrderTooltip<static> $tooltip
 */
class Chart extends Chartable implements Resolvable
{
    use ForwardsCalls;
    use HasAxes;
    use HasLegend;
    use HasSeries;
    use HasTextStyle;
    use HasTitle;
    use HasToolbox;
    use HasTooltip;
    use Inferrable;
    use InteractsWithData;

    /**
     * Whether to flip the x and y axes, only applicable to bar charts.
     *
     * @var bool
     */
    public $flip = false;

    /**
     * Get a property of the chart.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'tooltip' => new HigherOrderTooltip($this, $this->withTooltip()),
            default => $this->{$name}
        };
    }

    /**
     * Set whether to flip the x and y axes, only applicable to bar charts.
     *
     * @return $this
     */
    public function flip(bool $value = true): static
    {
        $this->flip = $value;

        return $this;
    }

    /**
     * Set to not flip the x and y axes.
     *
     * @return $this
     */
    public function dontflip(): static
    {
        return $this->flip(false);
    }

    /**
     * Determine if the x and y axes are flipped.
     */
    public function isFlipped(): bool
    {
        return $this->flip;
    }

    /**
     * Resolve the data into the components.
     *
     * @param  list<mixed>  $data
     */
    public function resolve(mixed $data): void
    {
        $this->resolveAxes($data);

        $this->resolveSeries($data);
    }

    /**
     * Resolve the axes with the given data.
     *
     * @param  list<mixed>  $data
     */
    protected function resolveAxes(mixed $data): void
    {
        if (! $this->requiresAxes()) {
            return;
        }

        $this->withMissingAxis(Dimension::X);

        $this->withMissingAxis(Dimension::Y);

        foreach ($this->getAxes() as $axis) {
            $dependent = $this->isFlipped() ? Dimension::Y : Dimension::X;

            if ($axis->getDimension() === $dependent && is_null($axis->getCategory())) {
                $axis->category($this->getCategory());
            }

            $axis->infer($this->infers())->resolve($data);
        }
    }

    /**
     * Get the representation of the chart.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        $this->define();

        $this->resolve($this->getSource() ?? []);

        return [
            'title' => $this->getTitle()?->toArray(),
            'legend' => $this->getLegend()?->toArray(),
            // 'grid' => $this->getGrid()?->toArray(),
            'xAxis' => $this->listAxes(Dimension::X),
            'yAxis' => $this->listAxes(Dimension::Y),
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
            'series' => $this->listSeries(),
            // 'color' => $this->getColor(),
            // 'backgroundColor' => $this->getBackgroundColor(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
