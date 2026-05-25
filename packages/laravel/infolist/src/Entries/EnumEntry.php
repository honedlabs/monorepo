<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use BackedEnum;
use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\EnumFormatter;

/**
 * @extends Entry<int|string|BackedEnum|null, BackedEnum|null>
 *
 * @method $this enum(string $value) Set the backing enum for the entry.
 * @method string|null getEnum() Get the backing enum for the entry.
 */
class EnumEntry extends Entry
{
    /**
     * Get the default formatter.
     *
     * @return Formatter<int|string|BackedEnum|null, BackedEnum|null>
     */
    public function defaultFormatter(): Formatter
    {
        return new EnumFormatter();
    }
}
