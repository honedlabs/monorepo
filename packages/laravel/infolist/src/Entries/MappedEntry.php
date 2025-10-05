<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use BackedEnum;
use Closure;
use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\MappedFormatter;

/**
 * @extends Entry<int|string|\BackedEnum, mixed>
 *
 * @method $this mapping(array<array-key, mixed>|\Closure(int|string|\BackedEnum|null):mixed $value) Set the mapping to use.
 * @method array<array-key, mixed>|Closure(int|string|BackedEnum|null):mixed getMapping() Get the mapping to use.
 * @method $this default(mixed $value) Set the default value to use if the value is not found in the mapping.
 * @method mixed getDefault() Get the default value to use if the value is not found in the mapping.
 */
class MappedEntry extends Entry
{
    /**
     * Get the default formatter.
     *
     * @return Formatter<int|string|BackedEnum, mixed>
     */
    public function defaultFormatter(): Formatter
    {
        return new MappedFormatter();
    }
}
