<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\EnumFormatter;

/**
 * @extends Entry<int|string|\BackedEnum|null, \BackedEnum|null>
 *
 * @method $this enum(string $value) Set the backing enum for the entry.
 * @method string|null getEnum() Get the backing enum for the entry.
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
