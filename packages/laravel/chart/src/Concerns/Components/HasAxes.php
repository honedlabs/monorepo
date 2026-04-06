<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Axis;
use Honed\Chart\AxisX;
use Honed\Chart\AxisY;
use Honed\Chart\Enums\Dimension;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;

trait HasAxes
{
    /**
     * The axes.
     *
     * @var \Illuminate\Support\Collection<int, Axis>
     */
    protected $axes;

    /**
     * Add an axis to the chart.
     *
     * @return $this
     */
    public function axis(Axis $axis): static
    {
        $this->axes = $this->getAxes()->push($axis);

        return $this;
    }

    /**
     * Add a y-axis to the chart.
     *
     * @param  Axis|(Closure(Axis):Axis)|bool|null  $value
     * @return $this
     */
    public function y(Axis|Closure|bool|null $value = true): static
    {
        $axis = match (true) {
            $value => $this->newAxis(Dimension::Y),
            ! $value => null,
            $value instanceof Closure => $value($this->newAxis(Dimension::Y)),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Add an x-axis to the chart.
     *
     * @param  Axis|(Closure(Axis):Axis)|bool|null  $value
     * @return $this
     */
    public function x(Axis|Closure|bool|null $value = true): static
    {
        $axis = match (true) {
            $value => $this->newAxis(Dimension::X),
            ! $value => null,
            $value instanceof Closure => $value($this->newAxis(Dimension::X)),
            default => $value,
        };

        return $this->axis($axis);
    }

    /**
     * Add axes to the chart.
     *
     * @param  Axis|\Illuminate\Support\Enumerable<int, Axis>|list<Axis>  $axes
     * @return $this
     */
    public function axes(Axis|Enumerable|array $axes): static
    {
        if ($axes instanceof Axis) {
            return $this->axis($axes);
        }

        $this->axes = $this->getAxes()->merge($axes);

        return $this;
    }

    /**
     * Get the axes.
     *
     * @return \Illuminate\Support\Collection<int, Axis>
     */
    public function getAxes(?Dimension $value = null): Collection
    {
        if ($value) {
            $axes = $this->axes ??= new Collection();

            return $axes->filter(
                static fn (Axis $axis) => $axis->getDimension() === $value
            )->values();
        }
        
        return $this->axes ??= new Collection();
    }

    /**
     * Determine if the chart has axes, optionally for a specific dimension.
     */
    public function hasAxes(?Dimension $value = null): bool
    {
        return $this->getAxes($value)->isNotEmpty();
    }

    /**
     * Create a new x-axis, or use the existing one.
     */
    public function newAxis(Dimension $value): Axis
    {
        return Axis::make()->dimension($value);
    }

    /**
     * Add a new axis to the chart.
     *
     * @return $this
     */
    public function withAxis(Dimension $value): static
    {
        return $this->axis($this->newAxis($value));
    }

    /**
     * Add a new axis to the chart if it does not exist.
     * 
     * @return $this
     */
    public function withMissingAxis(Dimension $value): static
    {
        if (! $this->hasAxes($value)) {
            return $this->withAxis($value);
        }

        return $this;
    }

    /**
     * Get the list of axes.
     *
     * @return list<array<string, mixed>>
     */
    public function listAxes(Dimension $value): array
    {
        return array_values(
            array_filter(
                array_map(
                    static fn (Axis $axis) => $axis->toArray() ?: null,
                    $this->getAxes($value)->all()
                )
            )
        );
    }
}
