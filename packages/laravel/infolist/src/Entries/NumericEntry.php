<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\NumericFormatter;

/**
 * @extends Entry<mixed, string>
 *
 * @method $this file(bool $value = true) Set whether to format the number as a file size.
 * @method bool isFile() Get whether the number should be formatted as a file size.
 * @method $this locale(string $value) Set the locale to use for formatting.
 * @method string getLocale() Get the locale to use for formatting.
 * @method $this decimals(int $decimals) Set the number of decimal places to display.
 * @method int|null getDecimals() Get the number of decimal places to display.
 */
class NumericEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('numeric');

        $this->formatter(NumericFormatter::class);
    }
}
