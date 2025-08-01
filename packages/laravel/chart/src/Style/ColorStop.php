<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Style\Concerns\HasColor;
use Honed\Chart\Style\Concerns\HasOffset;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class ColorStop implements Arrayable
{
    use HasColor;
    use HasOffset;

    /**
     * Create a new color stop.
     */
    public static function make(string|Rgb|Rgba $color, int $offset = 0): static
    {
        return resolve(static::class)
            ->color($color)
            ->offset($offset);
    }

    /**
     * Get the color stop as an array.
     * 
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            'offset' => $this->getOffset(),
            'color' => $this->getColor(),
        ];
    }
}