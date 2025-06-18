<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

class TextEntry extends BaseEntry
{
    use Concerns\CanBeText;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
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
    public function format($value)
    {
        return is_null($value) ? null : $this->formatText($value);
    }
}
