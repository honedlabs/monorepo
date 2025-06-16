<?php

declare(strict_types=1);

namespace Honed\List\Entries;

class TextEntry extends BaseEntry
{
    use Concerns\CanBeText;

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(self::TEXT);
    }

    /**
     * Format the value of the entry.
     * 
     * @param  mixed  $value
     * @return mixed
     */
    public function format(mixed $value): mixed
    {
        return is_null($value) ? null : $this->formatText($value);
    }
}