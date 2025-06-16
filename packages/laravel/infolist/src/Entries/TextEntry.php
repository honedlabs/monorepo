<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class TextEntry extends BaseEntry
{
    use Concerns\CanBeText;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::TEXT);
    }

    /**
     * Format the value of the entry.
     */
    public function format(mixed $value): mixed
    {
        return is_null($value) ? null : $this->formatText($value);
    }
}
