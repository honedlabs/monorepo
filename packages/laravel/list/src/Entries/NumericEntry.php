<?php

namespace Honed\List\Entries;

class NumericEntry extends BaseEntry
{
    use Concerns\CanBeNumeric;

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::NUMERIC);
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        return is_null($value) ? null : $this->formatNumeric($value);
    }
}