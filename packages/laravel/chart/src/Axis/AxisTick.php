<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Chart\Axis\Concerns\CanBeAlignedWithLabel;
use Honed\Chart\Axis\Concerns\CanBeInside;
use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Chart\Axis\Concerns\HasLength;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasData;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class AxisTick extends Primitive implements NullsAsUndefined
{
    use CanBeAlignedWithLabel;
    use CanBeInside;
    use CanBeShown;
    use HasData;
    use HasInterval;
    use HasLength;
    use HasLineStyle;

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
