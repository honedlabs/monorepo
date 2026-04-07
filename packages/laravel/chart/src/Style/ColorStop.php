<?php

declare(strict_types=1);

namespace Honed\Chart\Style;

use Honed\Chart\Concerns\Style\HasColor;
use Honed\Chart\Concerns\Style\HasOffset;
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
    final public function __construct(string|Rgb|Rgba $color, int $offset = 0)
    {
        $this->color($color);
        $this->offset($offset);
    }

    /**
     * Create a new color stop.
     */
    public static function make(string|Rgb|Rgba $color, int $offset = 0): static
    {
        return new static($color, $offset);
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
