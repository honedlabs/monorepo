<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\Contracts\Formatter;
use Honed\Core\Formatters\CurrencyFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumberFormatter;
use Honed\Core\Formatters\StringFormatter;

trait Formattable
{
    /**
     * @var \Honed\Core\Formatters\Contracts\Formatter
     */
    protected $formatter;

    /**
     * Set the formatter, chainable.
     *
     * @return $this
     */
    public function formatter(Formatter $formatter): static
    {
        $this->setFormatter($formatter);

        return $this;
    }

    /**
     * Set the formatter quietly.
     */
    public function setFormatter(?Formatter $formatter): void
    {
        if (\is_null($formatter)) {
            return;
        }

        $this->formatter = $formatter;
    }

    /**
     * Get the formatter.
     */
    public function getFormatter(): ?Formatter
    {
        return $this->formatter;
    }

    /**
     * Determine if the class has a formatter.
     */
    public function hasFormatter(): bool
    {
        return ! \is_null($this->formatter);
    }

    /**
     * Set the class to use a boolean formatter.
     *
     * @param  string|(\Closure():string)|null  $truthLabel
     * @param  string|(\Closure():string)|null  $falseLabel
     * @return $this
     */
    public function boolean(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null): static
    {
        return $this->formatter(BooleanFormatter::make($truthLabel, $falseLabel));
    }

    /**
     * Set the class to use a string formatter.
     *
     * @param  string|(\Closure():string)|null  $prefix
     * @param  string|(\Closure():string)|null  $suffix
     * @return $this
     */
    public function string(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null): static
    {
        return $this->formatter(StringFormatter::make($prefix, $suffix));
    }

    /**
     * Set the class to use a date formatter.
     *
     * @param  string|(\Closure():string)|null  $format
     * @param  bool|(\Closure():bool)  $diff
     * @param  string|(\Closure():string)|null  $timezone
     * @return $this
     */
    public function date(string|\Closure|null $format = null, bool|\Closure $diff = false, string|\Closure|null $timezone = null): static
    {
        return $this->formatter(DateFormatter::make($format, $diff, $timezone));
    }

    /**
     * Set the class to use a number formatter.
     *
     * @param  int|(\Closure():int)|null  $precision
     * @param  int|(\Closure():int)|null  $divideBy
     * @param  string|(\Closure():string)|null  $locale
     * @return $this
     */
    public function number(int|\Closure|null $precision = null, int|\Closure|null $divideBy = null, string|\Closure|null $locale = null): static
    {
        return $this->formatter(NumberFormatter::make($precision, $divideBy, $locale));
    }

    /**
     * Set the class to use a currency formatter.
     *
     * @param  string|(\Closure():string)|null  $currency
     * @param  int|(\Closure():int)|null  $precision
     * @param  string|(\Closure():string)|null  $locale
     * @return $this
     */
    public function currency(string|\Closure|null $currency = null, int|\Closure|null $precision = null, string|\Closure|null $locale = null): static
    {
        return $this->formatter(CurrencyFormatter::make($currency, $precision, $locale));
    }

    /**
     * Apply the formatter to the given value.
     *
     * @template T
     *
     * @param  T  $value
     * @return T|mixed
     */
    public function format(mixed $value)
    {
        if (! $this->hasFormatter()) {
            return $value;
        }

        return $this->formatter->format($value);
    }
}
