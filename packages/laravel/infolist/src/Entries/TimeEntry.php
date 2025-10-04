<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\TimeFormatter;

/**
 * @extends Entry<\Carbon\CarbonInterface|string|int|float, string>
 */
class TimeEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('time');

        $this->formatter(TimeFormatter::class);
    }
}
