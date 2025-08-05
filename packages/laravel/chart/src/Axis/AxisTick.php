<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Chart\Axis\Concerns\HasLength;
use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Axis\Concerns\CanBeAlignedWithLabel;
use Honed\Chart\Axis\Concerns\CanBeInside;

class AxisTick extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use CanBeAlignedWithLabel;
    use CanBeInside;
    use HasInterval;
    use HasLineStyle;
    use HasData;
    use HasLength;

    /**
     * Create a new axis tick.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the axis tick.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'alignWithLabel' => $this->isAlignedWithLabel(),
            'interval' => $this->getInterval(),
            'inside' => $this->isInside(),
            'length' => $this->getLength(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
            'customValues' => $this->getData(),
        ];
    }
}