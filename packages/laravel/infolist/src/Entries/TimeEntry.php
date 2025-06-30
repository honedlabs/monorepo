<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class TimeEntry extends BaseEntry
{
    use Concerns\CanBeDateTime;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->time();
    }

    /**
     * Format the value of the entry.
     *
     * @param  \Carbon\CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    public function format($value)
    {
        return $this->formatTime($value);
    }
}
