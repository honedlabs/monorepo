<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

use Honed\Chart\Style\ColorStop;

trait HasColorStops
{
    /**
     * The color stops.
     *
     * @var array<int, ColorStop>
     */
    protected $colorStops = [];

    /**
     * Add a color stop.
     *
     * @param  array<int, ColorStop>|ColorStop  $value
     * @return $this
     */
    public function colorStop(array|ColorStop $value): static
    {
        /** @var array<int, ColorStop> */
        $value = is_array($value) ? $value : func_get_args();

        $this->colorStops = [...$this->colorStops, ...$value];

        return $this;
    }

    /**
     * Add color stops.
     *
     * @param  array<int, ColorStop>  $value
     * @return $this
     */
    public function colorStops(array $value): static
    {
        return $this->colorStop($value);
    }

    /**
     * Get the color stops.
     *
     * @return array<int, ColorStop>
     */
    public function getColorStops(): array
    {
        return $this->colorStops;
    }

    /**
     * Get the color stops as an array.
     *
     * @return array<int, array<string, mixed>>
     */
    public function colorStopsToArray(): array
    {
        return array_map(
            static fn (ColorStop $colorStop) => $colorStop->toArray(),
            $this->getColorStops()
        );
    }
}
