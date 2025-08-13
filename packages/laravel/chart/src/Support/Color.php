<?php

declare(strict_types=1);

namespace Honed\Chart\Support;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Stringable;

final class Color
{
    /**
     * Get a color value.
     *
     * @return string|array<string, mixed>|null
     */
    public static function from(string|Rgb|Rgba|Gradient|null $color): string|array|null
    {
        return match (true) {
            $color instanceof Stringable => $color->__toString(),
            $color instanceof Gradient => $color->toArray(),
            default => $color,
        };
    }
}
