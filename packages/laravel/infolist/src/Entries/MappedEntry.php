<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\MappedFormatter;

/**
 * @extends Entry<int|string|\BackedEnum, mixed>
 */
class MappedEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter(MappedFormatter::class);
    }
}
