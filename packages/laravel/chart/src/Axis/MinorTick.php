<?php

declare(strict_types=1);

namespace Honed\Chart\Axis;

use Honed\Core\Primitive;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Chart\Axis\Concerns\HasLength;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Chart\Axis\Concerns\HasSplitNumber;

class MinorTick extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasSplitNumber;
    use HasLength;
    use HasLineStyle;

    /**
     * Create a new minor tick.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the minor tick.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'splitNumber' => $this->getSplitNumber(),
            'length' => $this->getLength(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}