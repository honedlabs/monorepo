<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use BackedEnum;
use Honed\Infolist\Formatters\EnumFormatter;

/**
 * @method static enum(class-string<\BackedEnum> $enum) Set the backing enum for the entry.
 * @method class-string<\BackedEnum> getEnum() Get the backing enum for the entry.
 * @method bool hasEnum() Check if the enum backing value is set.
 * @method bool missingEnum() Check if the enum backing value is missing.
 * 
 * @extends Entry<int|string|\BackedEnum|null, \BackedEnum|null>
 */
class EnumEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter(EnumFormatter::class);
    }
}