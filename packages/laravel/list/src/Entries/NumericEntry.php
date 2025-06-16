<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class NumericEntry extends BaseEntry
{
    use Concerns\CanBeNumeric;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::NUMERIC);
    }

    /**
     * Format the value of the entry.
     */
    public function format(mixed $value): mixed
    {
        return is_null($value) ? null : $this->formatNumeric($value);
    }
}
