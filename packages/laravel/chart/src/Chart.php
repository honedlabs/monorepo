<?php

declare(strict_types=1);

namespace Honed\Chart;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\HasSeries;
use Honed\Chart\Exceptions\MissingDataException;
use Honed\Core\Primitive;

class Chart extends Primitive
{
    use HasData;
    use HasSeries;

    /**
     * Create a new chart instance.
     */
    public static function make(mixed $data = null): static
    {
        return resolve(static::class)
            ->data($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function representation(): array
    {
        return [
            'xAxis' => $this->getXAxis()?->toArray(),
            'yAxis' => $this->getYAxis()?->toArray(),
            'series' => $this->getSeries(),
        ];
    }
}