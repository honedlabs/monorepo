<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Axis;
use Honed\Chart\Enums\Dimension;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;

trait HasAxes
{
    /**
     * The axes.
     *
     * @var Collection<int, Axis>|null
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

        if (is_null($axis)) {
            return $this;
        }

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

        if (is_null($axis)) {
            return $this;
        }

        return $this->axis($axis);
    }

    /**
     * Add axes to the chart.
     *
     * @param  Axis|Enumerable<int, Axis>|list<Axis>  $axes
     * @return $this
     */
    public function axes(Axis|Enumerable|array $axes): static
    {
        if ($axes instanceof Axis) {
            return $this->axis($axes);
        }

        $this->axes = $this->withAxes()->merge($axes);

        return $this;
    }

    /**
     * Get the axes.
     *
     * @return Collection<int, Axis>
     */
    public function getAxes(?Dimension $value = null): Collection
    {
        if ($value) {
            return $this->withAxes()
                ->filter(
                    static fn (Axis $axis) => $axis->getDimension() === $value
                )->values();
        }

        return $this->withAxes();
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
     * Get the first axis for a specific dimension, or create a new one if it does not exist.
     */
    public function withAxis(Dimension $value): Axis
    {
        $axis = $this->getAxes($value)->first();

        if (is_null($axis)) {
            $axis = $this->newAxis($value);

            $this->axis($axis);
        }

        return $axis;
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

    /**
     * Create a new collection of axes if one is not present.
     *
     * @return Collection<int, Axis>
     */
    protected function withAxes(): Collection
    {
        return $this->axes ??= new Collection();
    }
}
