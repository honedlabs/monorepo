<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\ColorFormatter;

/**
 * @extends Entry<mixed, string>
 */
class ColorEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('color');
    }

    /**
     * Get the default formatter.
     *
     * @return Formatter<mixed, string>
     */
    public function defaultFormatter(): Formatter
    {
        return new ColorFormatter();
    }
}
