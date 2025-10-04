<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\DateTimeFormatter;

/**
 * @extends Entry<\Carbon\CarbonInterface|string|int|float, string>
 */
class DateTimeEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('datetime');

        $this->formatter(DateTimeFormatter::class);
    }
}
