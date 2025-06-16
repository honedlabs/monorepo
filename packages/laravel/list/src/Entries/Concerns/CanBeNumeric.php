<?php

namespace Honed\List\Entries\Concerns;

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
     * Set the currency and locale to use for formatting the number as money.
     * 
     * @param  string|null  $currency
     * @param  string|null  $locale
     * @return $this
     */
    public function money(?string $currency = null, ?string $locale = null): static
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

        $value = $this->formatDivideBy((float) $value);

        return match (true) {
            $this->fileSize => Number::fileSize($value),
            $this->currency => Number::currency(
                $value,
                $this->getCurrency(),
                $this->getLocale()
            ),
            default => Number::format(
                $value,
                $this->getDecimals(),
                $this->getLocale()
            ),
        };
    }

    /**
     * Format the value by dividing it.
     * 
     * @param  float  $value
     * @return float
     */
    protected function formatDivideBy(float $value): float
    {
        $divideBy = $this->getDivideBy();

        return $divideBy ? $value / $divideBy : $value;
    }

}