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
     * @param string|(\Closure():string)|null $currency
     * @param int|(\Closure():int)|null $divideBy
     * @param string|(\Closure():string)|null $locale
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
     * @param string|(\Closure():string)|null $currency
     * @param int|(\Closure():int)|null $divideBy
     * @param string|(\Closure():string)|null $locale
     * @return $this
     */
    public static function make(string|\Closure|null $currency = null, int|\Closure|null $divideBy = 100, string|\Closure|null $locale = null): static
    {
        return resolve(static::class, compact('currency', 'divideBy', 'locale'));
    }

    /**
     * Format the value as a currency
     * 
     * @param mixed $value
     * @return string|null
     */
    public function format(mixed $value): string|null|false
    {
        if (!\is_numeric($value)) {
            return null;
        }

        $value = $this->hasDivideBy() ? $value / $this->getDivideBy() : $value;

        return Number::currency($value, $this->getCurrency(), $this->getLocale());
    }
}
