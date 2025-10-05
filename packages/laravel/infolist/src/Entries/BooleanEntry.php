<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Formatters\BooleanFormatter;

/**
 * @extends Entry<mixed, string>
 *
 * @method $this trueText(string $value) Set the text to display when the value is true.
 * @method string|null getTrueText() Get the text to display when the value is true.
 * @method $this falseText(string $value) Set the text to display when the value is false.
 * @method string|null getFalseText() Get the text to display when the value is false.
 */
class BooleanEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('boolean');
    }

    /**
     * Get the default formatter.
     *
     * @return Formatter<mixed, string>
     */
    public function defaultFormatter(): Formatter
    {
        return new BooleanFormatter();
    }
}
