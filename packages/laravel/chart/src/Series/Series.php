<?php

declare(strict_types=1);

namespace Honed\Chart\Series;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Concerns\HasChartType;
use Honed\Chart\Series\Concerns\RefersToAxis;
use Honed\Core\Concerns\HasName;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class Series extends Primitive implements NullsAsUndefined
{
    use HasName;
    use HasChartType;
    use RefersToAxis;

    /**
     * Create a new series instance.
     */
    public static function make(?string $name = null): static
    {
        return resolve(static::class)
            ->name($name);
    }

    /**
     * Get the representation of the series.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'type' => $this->getType(),
            'data' => [],
            'name' => $this->hasName() ? $this->getName() : null, // @refactor
            // 'xAxisIndex' => $this->xAxisIndex,
            // 'yAxisIndex' =>
        ];
    }
}