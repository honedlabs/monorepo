<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line;

use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class MarkLine extends Primitive implements NullsAsUndefined
{
    /**
     * Create a new mark line instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the mark line.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            // 'silent',
            // 'symbol',
            // 'symbolSize',
            // 'symbolOffset',
            // 'precision',
            // 'label',
            // 'lineStyle',
            // 'emphasis',
            // 'blur',
            // 'data',
            // '...animation'
        ];
    }
}
