<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Components\HasAxes;
use Honed\Chart\Concerns\Components\HasGrid;
use Honed\Chart\Concerns\Components\HasLegend;
use Honed\Chart\Concerns\Components\HasSeries;
use Honed\Chart\Concerns\Components\HasTextStyle;
use Honed\Chart\Concerns\Components\HasTitle;
use Honed\Chart\Concerns\Components\HasToolbox;
use Honed\Chart\Concerns\Components\HasTooltip;
use Honed\Chart\Concerns\InteractsWithData;
use Honed\Chart\Concerns\Proxies\Proxyable;
use Honed\Chart\Concerns\Style\HasColors;
use Honed\Chart\Concerns\Support\Inferrable;
use Honed\Chart\Contracts\Resolvable;
use Honed\Chart\Enums\ChartType;
use Honed\Chart\Enums\Dimension;
use Honed\Chart\Proxies\HigherOrderAxis;
use Honed\Chart\Proxies\HigherOrderGrid;
use Honed\Chart\Proxies\HigherOrderLegend;
use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\Proxies\HigherOrderTitle;
use Honed\Chart\Proxies\HigherOrderToolbox;
use Honed\Chart\Proxies\HigherOrderTooltip;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * @property-read HigherOrderAxis<static> $x
 * @property-read HigherOrderAxis<static> $y
 * @property-read HigherOrderGrid<static> $grid
 * @property-read HigherOrderTextStyle<static> $textStyle
 * @property-read HigherOrderTitle<static> $title
 * @property-read HigherOrderToolbox<static> $toolbox
 * @property-read HigherOrderTooltip<static> $tooltip
 */
class Chart extends Chartable implements Resolvable
{
    use ForwardsCalls;
    use HasAxes;
    use HasColors;
    use HasGrid;
    use HasLegend;
    use HasSeries;
    use HasTextStyle;
    use HasTitle;
    use HasToolbox;
    use HasTooltip;
    use Inferrable;
    use InteractsWithData;
    use Proxyable;

    /**
     * Whether to flip the x and y axes, only applicable to bar charts.
     *
     * @var bool
     */
    protected $flip = false;

    /**
     * Get a property of the chart.
     *
     * @param  non-empty-string  $name
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'x' => new HigherOrderAxis($this, $this->withAxis(Dimension::X)),
            'y' => new HigherOrderAxis($this, $this->withAxis(Dimension::Y)),
            'grid' => new HigherOrderGrid($this, $this->withGrid()),
            'legend' => new HigherOrderLegend($this, $this->withLegend()),
            'textStyle' => new HigherOrderTextStyle($this, $this->withTextStyle()),
            'title' => new HigherOrderTitle($this, $this->withTitle()),
            'toolbox' => new HigherOrderToolbox($this, $this->withToolbox()),
            'tooltip' => new HigherOrderTooltip($this, $this->withTooltip()),
            default => $this->defaultGet($name),
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
        if ($this->hasSeries(ChartType::Pie)) {
            return;
        }

        $this->withAxis(Dimension::X);

        $this->withAxis(Dimension::Y);

        foreach ($this->getAxes() as $axis) {
            $dependent = $this->isFlipped() ? Dimension::Y : Dimension::X;

            // dd($this->getCategory(), $this->getValue());
            if (! $axis->hasCategory()) {
                $axis->category(
                    $axis->getDimension()->is($dependent)
                        ? $this->getCategory()
                        : $this->getValue()
                );
            }

            $axis->generate($axis->getDimension()->is($dependent))
                ->infer($this->infers() || $axis->infers())
                ->resolve($data);
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

        $isPie = $this->hasSeries(ChartType::Pie);

        return [
            'title' => $this->getTitle()?->toArray(),
            'legend' => $this->getLegend()?->toArray(),
            'grid' => $this->getGrid()?->toArray(),
            'xAxis' => $isPie ? null : $this->listAxes(Dimension::X),
            'yAxis' => $isPie ? null : $this->listAxes(Dimension::Y),
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
            'color' => $this->hasColors() ? $this->listColors() : null,
            // 'backgroundColor' => $this->getBackgroundColor(),
            'textStyle' => $this->getTextStyle()?->toArray(),
        ];
    }
}
