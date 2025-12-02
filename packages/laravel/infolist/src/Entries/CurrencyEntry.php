<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries;

use Closure;
use Honed\Infolist\Contracts\Formatter;
use Honed\Infolist\Contracts\ScopedFormatter;
use Honed\Infolist\Formatters\CurrencyFormatter;

/**
 * @extends Entry<mixed, string>
 *
 * @implements ScopedFormatter<CurrencyFormatter>
 *
 * @method $this divide(int $value) Set the divide by amount to use for formatting.
 * @method int|null getDivide() Get the divide by amount to use for formatting.
 * @method $this cents() Set the divide by amount to use for formatting to cents.
 * @method $this locale(string $value) Set the locale to use for formatting.
 * @method string getLocale() Get the locale to use for formatting.
 * @method $this decimals(int $decimals) Set the number of decimal places to display.
 * @method int|null getDecimals() Get the number of decimal places to display.
 */
class CurrencyEntry extends Entry implements ScopedFormatter
{
    /**
     * The currency to use for formatting.
     *
     * @var string|Closure(mixed...):string|null
     */
    protected $currency;

    /**
     * Provide the instance with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type('numeric');
    }

    /**
     * Get the default formatter.
     *
     * @return Formatter<mixed, string>
     */
    public function defaultFormatter(): Formatter
    {
        return new CurrencyFormatter();
    }

    /**
     * Set the currency to use for formatting.
     *
     * @param  string|Closure(mixed...):string|null  $value
     * @return $this
     */
    public function currency(string|Closure|null $value): static
    {
        $this->currency = $value;

        return $this;
    }

    /**
     * Get the currency to use for formatting.
     */
    public function getCurrency(): ?string
    {
        /** @var string|null $currency */
        $currency = $this->evaluate($this->currency);

        return is_string($currency) ? mb_strtoupper($currency) : null;
    }

    /**
     * Scope the formatter.
     *
     * @param  CurrencyFormatter  $formatter
     * @return CurrencyFormatter
     */
    public function scopeFormatter(Formatter $formatter): Formatter
    {
        return $formatter
            ->currency($this->getCurrency());
    }
}
