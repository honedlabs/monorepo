<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\Zeroable;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Chart\Support\Concerns\HasSymbol;
use Honed\Chart\Support\Concerns\HasSymbolOffset;
use Honed\Chart\Support\Concerns\HasSymbolSize;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class AxisLine extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasLineStyle;
    use HasSymbol;
    use HasSymbolOffset;
    use HasSymbolSize;
    use Zeroable;

    /**
     * Create a new axis line.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the axis line.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'onZero' => $this->isOnZero(),
            'onZeroAxisIndex' => $this->getOnZeroAxisIndex(),
            'symbol' => $this->getSymbol(),
            'symbolSize' => $this->getSymbolSize(),
            'symbolOffset' => $this->getSymbolOffset(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}
