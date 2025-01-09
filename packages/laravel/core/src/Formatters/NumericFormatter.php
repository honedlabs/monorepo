<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Illuminate\Support\Number;

class NumericFormatter implements Contracts\Formatter
{
    /**
     * @var int
     */
    protected $precision;

    /**
     * @var int
     */
    protected $divideBy;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $currency;

    /**
     * Create a new numeric formatter instance.
     * 
     * @param int|null $precision
     * @param int|null $divideBy
     * @param string|null $locale
     * @param string|null $currency
     */
    public function __construct($precision = null, $divideBy = null, $locale = null, $currency = null)
    {
        $this->precision($precision);
        $this->divideBy($divideBy);
        $this->locale($locale);
        $this->currency($currency);
    }

    /**
     * Make a numeric formatter.
     *
     * @param int|null $precision
     * @param int|null $divideBy
     * @param string|null $locale
     * @param string|null $currency
     * 
     * @return static
     */
    public static function make($precision = null, $divideBy = null, $locale = null, $currency = null)
    {
        return resolve(static::class, compact('precision', 'divideBy', 'locale', 'currency'));
    }

    /**
     * Get or set the precision for the instance.
     * 
     * @param int|null $precision The precision to set, or null to retrieve the current precision.
     * @return int|null|$this The current precision when no argument is provided, or the instance when setting the precision.
     */
    public function precision($precision = null)
    {
        if (\is_null($precision)) {
            return $this->precision;
        }

        $this->precision = $precision;

        return $this;
    }

    /**
     * Determine if the instance has a precision.
     * 
     * @return bool True if a precision is set, false otherwise.
     */
    public function hasPrecision()
    {
        return ! \is_null($this->precision);
    }

    /**
     * Get or set the divide by amount for the instance.
     * 
     * @param int|null $divideBy The divide by amount to set, or null to retrieve the current divide by amount.
     * @return int|null|$this The current divide by amount when no argument is provided, or the instance when setting the divide by amount.
     */
    public function divideBy($divideBy = null)
    {
        if (\is_null($divideBy)) {
            return $this->divideBy;
        }

        $this->divideBy = $divideBy;

        return $this;
    }

    /**
     * Determine if the instance has a divide by amount set.
     * 
     * @return bool True if a divideBy is set, false otherwise.
     */
    public function hasDivideBy()
    {
        return ! \is_null($this->divideBy);
    }

    /**
     * Get or set the locale for the instance.
     * 
     * @param string|null $locale The locale to set, or null to retrieve the current locale.
     * @return string|null|$this The current locale when no argument is provided, or the instance when setting the locale.
     */
    public function locale($locale = null)
    {
        if (\is_null($locale)) {
            return $this->locale;
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * Determine if the instance has a locale set.
     * 
     * @return bool True if a locale is set, false otherwise.
     */
    public function hasLocale()
    {
        return ! \is_null($this->locale);
    }

    /**
     * Get or set the currency for the instance.
     * 
     * @param string|null $currency The currency to set, or null to retrieve the current currency.
     * @return string|null|$this The current currency when no argument is provided, or the instance when setting the currency.
     */
    public function currency($currency = null)
    {
        if (\is_null($currency)) {
            return $this->currency;
        }

        $this->currency = $currency;

        return $this;
    }

    /**
     * Determine if the instance has a currency set.
     * 
     * @return bool True if a currency is set, false otherwise.
     */
    public function hasCurrency()
    {
        return ! \is_null($this->currency);
    }

    /**
     * Format the value as a number.
     * 
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value)
    {
        if (\is_null($value) || ! \is_numeric($value)) {
            return null;
        }

        if ($this->hasDivideBy()) {
            $value = $value / $this->divideBy();
        }

        return match (true) {
            $this->hasCurrency() => Number::currency($value, $this->currency(), $this->locale()),
            $this->hasLocale() => Number::format($value, precision: $this->precision(), locale: $this->locale()),
            default => $value
        };
    }
}
