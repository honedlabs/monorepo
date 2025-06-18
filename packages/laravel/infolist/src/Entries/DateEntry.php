<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class DateEntry extends BaseEntry
{
    use Concerns\CanBeDateTime;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->date();
    }

    /**
     * Format the value of the entry.
     *
     * @param  \Carbon\CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    public function format($value)
    {
        return $this->formatDate($value);
    }
}
