<?php

namespace Honed\List\Entries\Concerns;

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
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return $this->locale;
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
}