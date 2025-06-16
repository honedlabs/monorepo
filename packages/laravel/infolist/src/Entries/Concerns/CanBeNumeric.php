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
     */
    protected ?int $decimals = null;

    /**
     * The locale to use for formatting the number.
     */
    protected ?string $locale = null;

    /**
     * The currency to use for formatting the number.
     */
    protected ?string $currency = null;

    /**
     * The divide by amount to use for formatting the number.
     */
    protected ?int $divideBy = null;

    /**
     * Whether to format the number as a file size.
     */
    protected bool $fileSize = false;

    /**
     * Set the number of decimal places to display.
     *
     * @return $this
     */
    public function decimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Get the number of decimal places to display.
     */
    public function getDecimals(): ?int
    {
        return $this->decimals;
    }

    /**
     * Set the locale to use for formatting the number.
     *
     * @return $this
     */
    public function locale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get the locale to use for formatting the number.
     */
    public function getLocale(): string
    {
        return $this->locale ?? App::getLocale();
    }

    /**
     * Set the currency to use for formatting the number.
     *
     * @return $this
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the currency to use for formatting the number.
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set the divide by amount to use for formatting the number.
     *
     * @return $this
     */
    public function divideBy(int $divideBy): static
    {
        $this->divideBy = $divideBy;

        return $this;
    }

    /**
     * Get the divide by amount to use for formatting the number.
     */
    public function getDivideBy(): ?int
    {
        return $this->divideBy;
    }

    /**
     * Set the currency and locale to use for formatting the number as money.
     *
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
     * @return $this
     */
    public function fileSize(bool $fileSize = true): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get whether the number should be formatted as a file size.
     */
    public function isFileSize(): bool
    {
        return $this->fileSize;
    }

    /**
     * Format the value as a number.
     */
    protected function formatNumeric(mixed $value): ?string
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
     */
    protected function formatDivideBy(float $value): float
    {
        $divideBy = $this->getDivideBy();

        return $divideBy ? $value / $divideBy : $value;
    }

    /**
     * Format the value as a file size.
     */
    protected function formatFileSize(float $value): string
    {
        return Number::fileSize($value);
    }

    /**
     * Format the value as a currency.
     */
    protected function formatCurrency(float $value): ?string
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
     */
    protected function formatNumber(float $value): ?string
    {
        $formatted = Number::format(
            $value, $this->getDecimals(), locale: $this->getLocale()
        );

        return $formatted ?: null;
    }
}
