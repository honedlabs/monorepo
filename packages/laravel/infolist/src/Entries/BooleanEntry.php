<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class BooleanEntry extends BaseEntry
{
    use Concerns\CanBeBoolean;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::BOOLEAN);
    }

    /**
     * Format the value of the entry.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function format($value)
    {
        return $this->formatBoolean($value);
    }
}
