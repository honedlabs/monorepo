<?php

namespace Honed\List\Entries;

class DateEntry extends BaseEntry
{
    use Concerns\CanBeDate;

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('date');

        $this->date();
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        return $this->formatDate($value);
    }
}