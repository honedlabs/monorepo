<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class NumericEntry extends BaseEntry
{
    use Concerns\CanBeNumeric;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
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
    public function format($value)
    {
        return is_null($value) ? null : $this->formatNumeric($value);
    }
}
