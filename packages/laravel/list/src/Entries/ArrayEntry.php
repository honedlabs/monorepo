<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class DateEntry extends BaseEntry
{
    use Concerns\CanBeArray;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::ARRAY);

        $this->date();
    }

    /**
     * Format the value of the entry.
     *
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        if (! is_array($value)) {
            return null;
        }

        return $this->formatArray($value);
    }
}
