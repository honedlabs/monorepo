<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

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
     * Get or set the formatter for the instance.
     * 
     * @param \Honed\Core\Contracts\Formats|null $formatter The formatter to set, or null to retrieve the current formatter.
     * @return \Honed\Core\Contracts\Formats|null|$this The current formatter when no argument is provided, or the instance when setting the formatter.
     */
    public function formatter($formatter = null)
    {
        if (\is_null($formatter)) {
            return $this->formatter;
        }

        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Determine if the instance has a formatter set.
     * 
     * @return bool True if a formatter is set, false otherwise.
     */
    public function hasFormatter()
    {
        return ! \is_null($this->formatter);
    }

    /**
     * Set the class to use a boolean formatter.
     *
     * @param string|null $true
     * @param string|null $false
     * @return $this
     */
    public function boolean($true = null, $false = null): static
    {
        return $this->formatter(BooleanFormatter::make($true, $false));
    }

    /**
     * Set the class to use a string formatter.
     *
     * @param string|null $prefix
     * @param string|null $suffix
     * @param int|null $limit    
     * 
     * @return $this
     */
    public function string($prefix = null, $suffix = null, $limit = null): static
    {
        return $this->formatter(StringFormatter::make($prefix, $suffix, $limit));
    }

    /**
     * Set the class to use a date formatter.
     *
     * @param string|null $date
     * @param string|null $timezone
     * @param bool $diff
     * 
     * @return $this
     */
    public function date($date = null, $timezone = null, $diff = false): static
    {
        return $this->formatter(DateFormatter::make($date, $timezone, $diff));
    }

    /**
     * Set the class to use a number formatter.
     *
     * @param int|null $precision
     * @param int|null $divideBy
     * @param string|null $locale
     * @param string|null $currency
     * 
     * @return $this
     */
    public function numeric($precision = null, $divideBy = null, $locale = null, $currency = null): static
    {
        return $this->formatter(NumericFormatter::make($precision, $divideBy, $locale, $currency));
    }

    /**
     * Apply the formatter to the given value.
     *
     * @param mixed $value
     * @return mixed
     */
    public function format(mixed $value)
    {
        return $this->hasFormatter() 
            ? $this->formatter->format($value) 
            : $value;
    }
}
