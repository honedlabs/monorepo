<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\Animatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\HasSeries;
use Honed\Chart\Exceptions\MissingDataException;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Chart extends Primitive implements NullsAsUndefined
{
    use HasData;
    use HasSeries;
    use Animatable;

    /**
     * Create a new chart instance.
     */
    public static function make(mixed $data = null): static
    {
        return resolve(static::class)
            ->data($data);
    }

    /**
     * Resolve the data into the components.
     */
    protected function resolve(): void
    {
        // If no data is set, throw an exception
        
        // Loop over axes

        // Loop over series
    }

    /**
     * {@inheritDoc}
     */
    protected function representation(): array
    {
        $this->define();

        $this->resolve();

        return [
            'xAxis' => $this->getXAxis()?->toArray(),
            'yAxis' => $this->getYAxis()?->toArray(),
            'series' => $this->getSeries(),
            ...$this->getAnimationParameters(),
        ];
    }
}