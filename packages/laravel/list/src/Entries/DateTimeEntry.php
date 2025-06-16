<?php

namespace Honed\List\Entries;

class DateEntry extends BaseEntry
{
    use Concerns\CanBeDateTime;

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::DATETIME);

        $this->dateTime();
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        return $this->formatDateTime($value);
    }
}