<?php

declare(strict_types=1);

namespace Honed\Chart\Label;

use Honed\Chart\Concerns\CanBeShown;
use Honed\Chart\Concerns\HasLineStyle;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class LabelLine extends Primitive implements NullsAsUndefined
{
    use CanBeShown;
    use HasLineStyle;

    /**
     * Create a new label line instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the array representation of the label line.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'show' => $this->isShown(),
            'lineStyle' => $this->getLineStyle()?->toArray(),
        ];
    }
}
