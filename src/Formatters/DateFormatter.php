<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

class DateFormatter implements Contracts\Formatter
{
    public static function make(): self
    {
        return new self();
    }

    public function format(mixed $value): string
    {
        return (string) $value;
    }
}
