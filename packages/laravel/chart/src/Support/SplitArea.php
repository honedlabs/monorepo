<?php

declare(strict_types=1);

namespace Honed\Chart\Support;

use Honed\Chart\Axis\Concerns\HasInterval;
use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasAreaStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class SplitArea extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasAreaStyle;
    use HasInterval;

    /**
     * Create a new split area.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the split area.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'interval' => $this->getInterval(),
            'show' => $this->isShown(),
            'areaStyle' => $this->getAreaStyle()?->toArray(),
        ];
    }
}
