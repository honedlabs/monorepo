<?php

declare(strict_types=1);

namespace Honed\Chart\Support;

use Honed\Chart\Style\Rgba;
use Illuminate\Support\Str;

final class Color
{
    /**
     * Get a color value.
     */
    public static function from(string|Rgba|null $color): ?string
    {
        return match (true) {
            is_null($color) => null,
            $color instanceof Rgba => $color->toString(),
            Str::startsWith('rgb', $color) => $color,
            default => Str::startsWith('#', $color)
        };
    }
}