<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\Contracts\Formatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\StringFormatter;

trait Formattable
{
    /**
     * @var \Honed\Core\Formatters\Contracts\Formatter|null
     */
    protected $formatter = null;

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
     * Determine if the class does not have a formatter.
     */
    public function missingFormatter(): bool
    {
        return \is_null($this->formatter);
    }

    /**
     * Determine if the class has a formatter.
     */
    public function hasFormatter(): bool
    {
        return ! $this->missingFormatter();
    }

    /**
     * Set the class to use a boolean formatter.
     *
     * @return $this
     */
    public function asBoolean(string|\Closure|null $truthLabel = null, string|\Closure|null $falseLabel = null): static
    {
        return $this->formatter(BooleanFormatter::make($truthLabel, $falseLabel));
    }

    /**
     * Set the class to use a string formatter.
     *
     * @return $this
     */
    public function asString(string|\Closure|null $prefix = null, string|\Closure|null $suffix = null): static
    {
        return $this->formatter(StringFormatter::make($prefix, $suffix));
    }

    /**
     * Set the class to use a date formatter.
     *
     * @return $this
     */
    public function asDate(string|\Closure|null $format = null, bool|\Closure $diff = false, string|\Closure|null $timezone = null): static
    {
        return $this->formatter(DateFormatter::make($format, $diff, $timezone));
    }

    // public function asNumeric()

    // public function asCurrency()

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
        if ($this->missingFormatter()) {
            return $value;
        }

        return $this->formatter->format($value);
    }
}
