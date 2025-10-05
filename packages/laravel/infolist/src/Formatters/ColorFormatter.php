<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Contracts\Formatter;
use Illuminate\Support\Str;

/**
 * @implements Formatter<mixed, string>
 */
class ColorFormatter implements Formatter
{
    /**
     * Format the value as a hex color.
     *
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        if (! is_string($value)) {
            return null;
        }

        return Str::start($value, '#');
    }
}
