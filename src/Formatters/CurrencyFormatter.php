<?php

namespace Honed\Core\Formatters;

use Honed\Core\Concerns\HasLocale;
use Illuminate\Support\Number;

class CurrencyFormatter implements Contracts\Formatter
{
    use Concerns\HasCurrency;
    use Concerns\HasDivideBy;
    use HasLocale;

    /**
     * Create a new currency formatter instance with the currency, precision, divide by, and locale.
     *
     * @param  string|(\Closure():string)|null  $currency
     * @param  int|(\Closure():int)|null  $divideBy
     * @param  string|(\Closure():string)|null  $locale
     */
    public function __construct(string|\Closure|null $currency = null, int|\Closure|null $divideBy = 100, string|\Closure|null $locale = null)
    {
        $this->setCurrency($currency);
        $this->setDivideBy($divideBy);
        $this->setLocale($locale);
    }

    /**
     * Make a currency formatter with the currency,precision, divide by, and locale.
     *
     * @param  string|(\Closure():string)|null  $currency
     * @param  int|(\Closure():int)|null  $divideBy
     * @param  string|(\Closure():string)|null  $locale
     * @return $this
     */
    public static function make(string|\Closure|null $currency = null, int|\Closure|null $divideBy = 100, string|\Closure|null $locale = null): static
    {
        return resolve(static::class, compact('currency', 'divideBy', 'locale'));
    }

    /**
     * Format the value as a currency
     */
    public function format(mixed $value): ?string
    {
        if (\is_null($value) || ! \is_numeric($value)) {
            return null;
        }

        $value = (float) $value;
        $value = $this->hasDivideBy() ? $value / $this->getDivideBy() : $value;

        $result = Number::currency($value, $this->getCurrency() ?? Number::defaultCurrency(), $this->getLocale());

        return (bool) $result ? $result : null;
    }

    /**
     * Shorthand to specify that the currency is stored in cents
     *
     * @return $this
     */
    public function cents(): static
    {
        return $this->divideBy(100);
    }

    /**
     * Shorthand to specify that the currency is stored in dollars
     *
     * @return $this
     */
    public function dollars(): static
    {
        return $this->divideBy(1);
    }
}
