<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Formats;
use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumericFormatter;
use Honed\Core\Formatters\StringFormatter;

trait HasFormatter
{
    /**
     * @var \Honed\Core\Contracts\Formats
     */
    protected $formatter;

    /**
     * Set the formatter for the instance.
     *
     * @return $this
     */
    public function formatter(?Formats $formatter): static
    {
        if (! \is_null($formatter)) {
            $this->formatter = $formatter;
        }

        return $this;
    }

    /**
     * Get the formatter for the instance.
     */
    public function getFormatter(): ?Formats
    {
        return $this->formatter;
    }

    /**
     * Determine if the instance has a formatter set.
     */
    public function hasFormatter(): bool
    {
        return isset($this->formatter);
    }

    /**
     * Set the class to use a boolean formatter.
     *
     * @return $this
     */
    public function formatBoolean(?string $true = null, ?string $false = null): static
    {
        return $this->formatter(BooleanFormatter::make($true, $false));
    }

    /**
     * Set the class to use a string formatter.
     *
     * @return $this
     */
    public function formatString(
        ?string $prefix = null,
        ?string $suffix = null,
        ?int $limit = null): static
    {
        return $this->formatter(StringFormatter::make($prefix, $suffix, $limit));
    }

    /**
     * Set the class to use a date formatter.
     *
     * @return $this
     */
    public function formatDate(
        ?string $date = null,
        ?string $timezone = null,
        ?bool $diff = false): static
    {
        return $this->formatter(DateFormatter::make($date, $timezone, $diff));
    }

    /**
     * Set the class to use a number formatter.
     *
     * @return $this
     */
    public function formatNumeric(
        ?int $precision = null,
        ?int $divideBy = null,
        ?string $locale = null,
        ?string $currency = null): static
    {
        return $this->formatter(NumericFormatter::make($precision, $divideBy, $locale, $currency));
    }

    /**
     * Apply the formatter to the given value.
     *
     * @return mixed
     */
    public function format(mixed $value)
    {
        return $this->hasFormatter()
            ? $this->formatter->format($value)
            : $value;
    }
}
