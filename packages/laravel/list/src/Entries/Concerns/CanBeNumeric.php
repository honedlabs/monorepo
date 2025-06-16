<?php

namespace Honed\List\Entries\Concerns;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;

trait CanBeNumeric
{
    /**
     * The number of decimal places to display.
     * 
     * @var int|null
     */
    protected ?int $decimals;

    /**
     * The locale to use for formatting the number.
     * 
     * @var string|null
     */
    protected ?string $locale;

    /**
     * The currency to use for formatting the number.
     * 
     * @var string|null
     */
    protected ?string $currency;

    /**
     * The divide by amount to use for formatting the number.
     * 
     * @var int|null
     */
    protected ?int $divideBy;

    /**
     * Whether to format the number as a file size.
     * 
     * @var bool
     */
    protected bool $fileSize = false;

    /**
     * Set the number of decimal places to display.
     * 
     * @param  int  $decimals
     * @return $this
     */
    public function decimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get the number of decimal places to display.
     * 
     * @return int|null
     */
    public function getDecimals(): ?int
    {
        return $this->decimals;
    }

    /**
     * Determine if decimal places are set.
     * 
     * @return bool
     */
    public function hasDecimals(): bool
    {
        return isset($this->decimals);
    }

    /**
     * Set the locale to use for formatting the number.
     * 
     * @param  string  $locale
     * @return $this
     */
    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale to use for formatting the number.
     * 
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Determine if a locale is set.
     * 
     * @return bool
     */
    public function hasLocale(): bool
    {
        return isset($this->locale);
    }

    /**
     * Set the currency to use for formatting the number.
     * 
     * @param  string  $currency
     * @return $this
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the currency to use for formatting the number.
     * 
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Determine if a currency is set.
     * 
     * @return bool
     */
    public function hasCurrency(): bool
    {
        return isset($this->currency);
    }

    /**
     * Set the divide by amount to use for formatting the number.
     * 
     * @param  int  $divideBy
     * @return $this
     */
    public function divideBy(int $divideBy): static
    {
        $this->divideBy = $divideBy;

        return $this;
    }

    /**
     * Get the divide by amount to use for formatting the number.
     * 
     * @return int|null
     */
    public function getDivideBy(): ?int
    {
        return $this->divideBy;
    }

    /**
     * Determine if a divide by amount is set.
     * 
     * @return bool
     */
    public function hasDivideBy(): bool
    {
        return isset($this->divideBy);
    }

    /**
     * Set whether to format the number as a file size.
     * 
     * @param  bool  $fileSize
     * @return $this
     */
    public function fileSize(bool $fileSize = true): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get whether the number should be formatted as a file size.
     * 
     * @return bool
     */
    public function isFileSize(): bool
    {
        return $this->fileSize;
    }

    /**
     * Format the value as a number.
     * 
     * @param  mixed  $value
     * @return string|null
     */
    protected function formatNumeric(mixed $value): ?string
    {
        if (! is_numeric($value)) {
            return null;
        }

        $pipes = [
            'formatDivideBy',
            'formatFileSize',
            'formatMoney',
            'formatNumber',
        ];

        return array_reduce(
            $pipes,
            fn ($value, $pipe) => $this->{$pipe}($value),
            (float) $value
        );
    }

    /**
     * Format the value by dividing it.
     * 
     * @param  float  $value
     * @return float
     */
    protected function formatDivideBy(float $value): float
    {
        return $this->hasDivideBy() 
            ? $value / $this->getDivideBy()
            : $value;
    }

    /**
     * Format the value as a file size.
     * 
     * @param  float  $value
     * @return string|float
     */
    protected function formatFileSize(float $value): string|float
    {
        if (! $this->isFileSize()) {
            return $value;
        }

        return Number::fileSize($value);
    }

    /**
     * Format the value as money.
     * 
     * @param  float|string  $value
     * @return string|float
     */
    protected function formatMoney(float|string $value): string|float
    {
        if (! $this->hasCurrency()) {
            return $value;
        }

        return Number::currency(
            $value,
            $this->getCurrency(),
            $this->getLocale()
        );
    }

    /**
     * Format the value as a number.
     * 
     * @param  float|string  $value
     * @return string
     */
    protected function formatNumber(float|string $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        $locale = $this->getLocale() ?? app()->getLocale();

        return Number::format(
            $value,
            $this->getDecimals(),
            $this->getLocale()
        );
    }
}