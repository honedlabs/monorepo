<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Contracts\Formats;
use Illuminate\Support\Number;

class NumberFormatter implements Formats
{
    /**
     * @var int|null
     */
    protected $precision = null;

    /**
     * @var int|null
     */
    protected $divideBy = null;

    /**
     * @var string|null
     */
    protected $locale = null;

    /**
     * @var string|null
     */
    protected $currency = null;

    /**
     * Make a new number formatter.
     *
     * @param  int|null  $precision
     * @param  int|null  $divideBy
     * @param  string|null  $locale
     * @param  string|null  $currency
     * @return static
     */
    public static function make($precision = null, $divideBy = null, $locale = null, $currency = null)
    {
        return resolve(static::class)
            ->precision($precision)
            ->divideBy($divideBy)
            ->locale($locale)
            ->currency($currency);
    }

    /**
     * Set the precision for the instance.
     *
     * @param  int|null  $precision
     * @return $this
     */
    public function precision($precision = null)
    {
        if (! \is_null($precision)) {
            $this->precision = $precision;
        }

        return $this;
    }

    /**
     * Get the precision for the instance.
     *
     * @return int|null
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Determine if the instance has a precision.
     *
     * @return bool
     */
    public function hasPrecision()
    {
        return ! \is_null($this->precision);
    }

    /**
     * Set the divide by amount for the instance.
     *
     * @param  int|null  $divideBy
     * @return $this
     */
    public function divideBy($divideBy = null)
    {
        if (! \is_null($divideBy)) {
            $this->divideBy = $divideBy;
        }

        return $this;
    }

    /**
     * Get the divide by amount for the instance.
     *
     * @return int|null
     */
    public function getDivideBy()
    {
        return $this->divideBy;
    }

    /**
     * Set the divide by amount to 100, to indicate the value is stored in cents.
     *
     * @return $this
     */
    public function cents()
    {
        return $this->divideBy(100);
    }

    /**
     * Determine if the instance has a divide by amount set.
     *
     * @return bool
     */
    public function hasDivideBy()
    {
        return ! \is_null($this->divideBy);
    }

    /**
     * Get or set the locale for the instance.
     *
     * @param  string|null  $locale
     * @return $this
     */
    public function locale($locale = null)
    {
        if (! \is_null($locale)) {
            $this->locale = $locale;
        }

        return $this;
    }

    /**
     * Get the locale for the instance.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Determine if the instance has a locale set.
     *
     * @return bool
     */
    public function hasLocale()
    {
        return ! \is_null($this->locale);
    }

    /**
     * Set the currency for the instance.
     *
     * @param  string|null  $currency
     * @return $this
     */
    public function currency($currency = null)
    {
        if (! \is_null($currency)) {
            $this->currency = $currency;
        }

        return $this;
    }

    /**
     * Get the currency for the instance.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Determine if the instance has a currency set.
     *
     * @return bool
     */
    public function hasCurrency()
    {
        return ! \is_null($this->currency);
    }

    /**
     * Format the value as a number.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function format($value)
    {
        if (\is_null($value) || ! \is_numeric($value)) {
            return null;
        }

        if ($this->hasDivideBy()) {
            $value = $value / $this->getDivideBy();
        }

        return match (true) {
            $this->hasCurrency() => Number::currency($value, $this->getCurrency(), $this->getLocale()), // @phpstan-ignore-line
            $this->hasLocale() => Number::format($value, precision: $this->getPrecision(), locale: $this->getLocale()), // @phpstan-ignore-line
            default => $value
        };
    }
}
