<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\DateFormatter;

/**
 * @extends Entry<\Carbon\CarbonInterface|string|int|float, string>
 *
 * @method $this using(string $value) Set the format to use for formatting a carbon instance.
 * @method string getDateFormat() Get the format to use for formatting a carbon instance.
 * @method $this since(bool $value = true) Set whether to use Carbon's diffForHumans to format the date.
 * @method bool isSince() Get whether to use Carbon's diffForHumans to format the date.
 * @method $this timezone(string $value) Set the timezone to use for formatting dates.
 * @method string|null getTimezone() Get the timezone to use for formatting dates.
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
