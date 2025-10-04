<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\DateFormatter;

/**
 * @extends Entry<\Carbon\CarbonInterface|string|int|float, string>
 */
class DateEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('date');

        $this->formatter(DateFormatter::class);
    }
}
