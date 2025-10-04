<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Honed\Infolist\Formatters\CurrencyFormatter;

/**
 * @extends Entry<mixed, string>
 *
 * @method $this currency(string $value) Set the currency to use for formatting.
 * @method string|null getCurrency() Get the currency to use for formatting.
 * @method $this divide(int $value) Set the divide by amount to use for formatting.
 * @method int|null getDivide() Get the divide by amount to use for formatting.
 * @method $this cents() Set the divide by amount to use for formatting to cents.
 * @method $this locale(string $value) Set the locale to use for formatting.
 * @method string getLocale() Get the locale to use for formatting.
 * @method $this decimals(int $decimals) Set the number of decimal places to display.
 * @method int|null getDecimals() Get the number of decimal places to display.
 */
class CurrencyEntry extends Entry
{
    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('numeric');

        $this->formatter(CurrencyFormatter::class);
    }
}
