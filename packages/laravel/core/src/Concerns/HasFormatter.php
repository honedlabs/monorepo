<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Formatters\BooleanFormatter;
use Honed\Core\Formatters\DateFormatter;
use Honed\Core\Formatters\NumberFormatter;
use Honed\Core\Formatters\StringFormatter;

trait HasFormatter
{
    /**
     * @var \Honed\Core\Contracts\Formats|null
     */
    protected $formatter;

    /**
     * Set the formatter for the instance.
     *
     * @param  \Honed\Core\Contracts\Formats|null  $formatter
     * @return $this
     */
    public function formatter($formatter)
    {
        if (! \is_null($formatter)) {
            $this->formatter = $formatter;
        }

        return $this;
    }

    /**
     * Get the formatter for the instance.
     *
     * @return \Honed\Core\Contracts\Formats|null
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * Determine if the instance has a formatter set.
     *
     * @return bool
     */
    public function hasFormatter()
    {
        return ! \is_null($this->formatter);
    }

    /**
     * Set the class to use a boolean formatter.
     *
     * @param  string|null  $true
     * @param  string|null  $false
     * @return $this
     */
    public function formatBoolean($true = null, $false = null)
    {
        return $this->formatter(BooleanFormatter::make($true, $false));
    }

    /**
     * Set the class to use a string formatter.
     *
     * @param  string|null  $prefix
     * @param  string|null  $suffix
     * @param  int|null  $limit
     * @return $this
     */
    public function formatString($prefix = null, $suffix = null, $limit = null)
    {
        return $this->formatter(StringFormatter::make($prefix, $suffix, $limit));
    }

    /**
     * Set the class to use a date formatter.
     *
     * @param  string|null  $date
     * @param  string|null  $timezone
     * @param  bool|null  $diff
     * @return $this
     */
    public function formatDate($date = null, $timezone = null, $diff = false)
    {
        return $this->formatter(DateFormatter::make($date, $timezone, $diff));
    }

    /**
     * Set the class to use a number formatter.
     *
     * @param  int|null  $precision
     * @param  int|null  $divideBy
     * @param  string|null  $locale
     * @param  string|null  $currency
     * @return $this
     */
    public function formatNumber($precision = null, $divideBy = null, $locale = null, $currency = null)
    {
        return $this->formatter(NumberFormatter::make($precision, $divideBy, $locale, $currency));
    }

    /**
     * Apply the formatter to the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function format($value)
    {
        return $this->hasFormatter()
            ? $this->formatter->format($value)
            : $value;
    }
}
