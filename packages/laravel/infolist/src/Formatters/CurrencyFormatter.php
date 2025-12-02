<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters;

use Honed\Infolist\Concerns\HasDecimals;
use Honed\Infolist\Formatters\Support\LocalisedFormatter;
use Illuminate\Support\Number;

/**
 * @extends LocalisedFormatter<mixed, string>
 */
class CurrencyFormatter extends LocalisedFormatter
{
    use HasDecimals;

    /**
     * The currency to use for formatting.
     *
     * @var string|null
     */
    protected $currency;

    /**
     * The divide by amount to use for formatting.
     *
     * @var int|null
     */
    protected $divide = null;

    /**
     * Set the currency to use for formatting.
     *
     * @return $this
     */
    public function currency(?string $value): static
    {
        $this->currency = $value ? mb_strtoupper($value) : null;

        return $this;
    }

    /**
     * Get the currency to use for formatting.
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Set the divide by amount to use for formatting.
     *
     * @return $this
     */
    public function divide(?int $value): static
    {
        $this->divide = $value;

        return $this;
    }

    /**
     * Get the divide by amount to use for formatting.
     */
    public function getDivide(): ?int
    {
        return $this->divide;
    }

    /**
     * Set the divide by amount to use for formatting to cents.
     *
     * @return $this
     */
    public function cents(): static
    {
        return $this->divide(100);
    }

    /**
     * Format the value as a currency.
     *
     * @return string|null
     */
    public function format(mixed $value): mixed
    {
        if (! is_numeric($value)) {
            return null;
        }

        $value = is_string($value) ? (float) $value : $value;

        if ($this->getDivide()) {
            $value = $value / $this->getDivide();
        }

        return Number::currency(
            number: $value,
            in: $this->getCurrency() ?? '',
            locale: $this->getLocale(),
            precision: $this->getDecimals()
        ) ?: null;
    }
}
