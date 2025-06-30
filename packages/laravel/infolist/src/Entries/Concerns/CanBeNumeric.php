<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;

trait CanBeNumeric
{
    public const NUMERIC = 'numeric';

    /**
     * The number of decimal places to display.
     *
     * @var int|null
     */
    protected $decimals = null;

    /**
     * The locale to use for formatting the number.
     *
     * @var string|null
     */
    protected $locale = null;

    /**
     * The currency to use for formatting the number.
     *
     * @var string|null
     */
    protected $currency = null;

    /**
     * The divide by amount to use for formatting the number.
     *
     * @var int|null
     */
    protected $divideBy = null;

    /**
     * Whether to format the number as a file size.
     *
     * @var bool
     */
    protected $fileSize = false;

    /**
     * Set the number of decimal places to display.
     *
     * @param  int  $decimals
     * @return $this
     */
    public function decimals($decimals)
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get the number of decimal places to display.
     *
     * @return int|null
     */
    public function getDecimals()
    {
        return $this->decimals;
    }

    /**
     * Set the locale to use for formatting the number.
     *
     * @param  string  $locale
     * @return $this
     */
    public function locale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale to use for formatting the number.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Set the currency to use for formatting the number.
     *
     * @param  string  $currency
     * @return $this
     */
    public function currency($currency)
    {
        $this->currency = mb_strtoupper($currency);

        return $this;
    }

    /**
     * Get the currency to use for formatting the number.
     *
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the divide by amount to use for formatting the number.
     *
     * @param  int  $divideBy
     * @return $this
     */
    public function divideBy($divideBy)
    {
        $this->divideBy = $divideBy;

        return $this;
    }

    /**
     * Get the divide by amount to use for formatting the number.
     *
     * @return int|null
     */
    public function getDivideBy()
    {
        return $this->divideBy;
    }

    /**
     * Set the currency and locale to use for formatting the number as money.
     *
     * @param  string|null  $currency
     * @param  string|null  $locale
     * @return $this
     */
    public function money($currency = null, $locale = null)
    {
        $this->currency = $currency;
        $this->locale = $locale;

        return $this;
    }

    /**
     * Set whether to format the number as a file size.
     *
     * @param  bool  $fileSize
     * @return $this
     */
    public function fileSize($fileSize = true)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get whether the number should be formatted as a file size.
     *
     * @return bool
     */
    public function isFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Format the value as a number.
     *
     * @param  mixed  $value
     * @return string|null
     */
    protected function formatNumeric($value)
    {
        if (! is_numeric($value)) {
            return null;
        }

        $value = $this->formatDivideBy((float) $value);

        return match (true) {
            $this->fileSize => $this->formatFileSize($value),
            (bool) $this->currency => $this->formatCurrency($value),
            default => $this->formatNumber($value),
        };
    }

    /**
     * Format the value by dividing it.
     *
     * @param  float  $value
     * @return float
     */
    protected function formatDivideBy($value)
    {
        $divideBy = $this->getDivideBy();

        return $divideBy ? $value / $divideBy : $value;
    }

    /**
     * Format the value as a file size.
     *
     * @param  float  $value
     * @return string
     */
    protected function formatFileSize($value)
    {
        return Number::fileSize($value);
    }

    /**
     * Format the value as a currency.
     *
     * @param  float  $value
     * @return string|null
     */
    protected function formatCurrency($value)
    {
        /** @var string */
        $currency = $this->getCurrency();

        $formatted = Number::currency(
            $value, $currency, $this->getLocale(), $this->getDecimals() ?? 2
        );

        return $formatted ?: null;
    }

    /**
     * Format the value as a number.
     *
     * @param  float  $value
     * @return string|null
     */
    protected function formatNumber($value)
    {
        $formatted = Number::format(
            $value, $this->getDecimals(), locale: $this->getLocale()
        );

        return $formatted === false ? null : $formatted;
    }
}
