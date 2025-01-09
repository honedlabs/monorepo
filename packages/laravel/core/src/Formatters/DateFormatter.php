<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class DateFormatter implements Contracts\Formatter
{
    /**
     * @var string
     */
    protected $date;

    /**
     * @var string
     */
    protected $timezone;

    /**
     * @var bool
     */
    protected $since;

    /**
     * Create a new date formatter instance.
     * 
     * @param string|null $date
     * @param string|null $timezone
     * @param bool $diff
     */
    public function __construct($date = null, $timezone = null, $diff = false)
    {
        $this->date($date);
        $this->timezone($timezone);
        $this->since($diff);
    }

    /**
     * Make a date formatter.
     * 
     * @param string|null $date
     * @param string|null $timezone
     * @param bool $diff
     * @return static
     */
    public static function make($date = null, $timezone = null, $diff = false)
    {
        return resolve(static::class, compact('format', 'timezone', 'diff'));
    }

    /**
     * Get or set the date for the instance.
     * 
     * @param string|null $date The date to set, or null to retrieve the current date.
     * @return string|null|$this The current date when no argument is provided, or the instance when setting the date.
     */
    public function date($date = null)
    {
        if (\is_null($date)) {
            return $this->date;
        }

        $this->date = $date;

        return $this;
    }

    /**
     * Determine if the instance has a date set.
     * 
     * @return bool True if a date is set, false otherwise.
     */
    public function hasDate()
    {
        return ! \is_null($this->date);
    }

    /**
     * Get or set the timezone for the instance.
     * 
     * @param string|null $timezone The timezone to set, or null to retrieve the current timezone.
     * @return string|null|$this The current timezone when no argument is provided, or the instance when setting the timezone.
     */
    public function timezone($timezone = null)
    {
        if (\is_null($timezone)) {
            return $this->timezone;
        }

        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Determine if the instance has a timezone set.
     * 
     * @return bool True if a timezone is set, false otherwise.
     */
    public function hasTimezone()
    {
        return ! \is_null($this->timezone);
    }

    /**
     * Set the instance to use diff for humans.
     *
     * @param bool $since The diff for humans state to set.
     * @return $this
     */
    public function since($since = true)
    {
        $this->since = $since;

        return $this;
    }

    /**
     * Determine if the instance uses diff for humans.
     * 
     * @return bool True if the instance uses diff for humans, false otherwise.
     */
    public function usesDiffForHumans()
    {
        return $this->since;
    }

    /**
     * Format the value as a string.
     * 
     * @return string|null
     */
    public function format($value)
    {
        if (\is_null($value)) {
            return null;
        }

        try {
            return $this->usesDiffForHumans()
                ? Carbon::parse($value, $this->timezone())->diffForHumans()
                : Carbon::parse($value, $this->timezone())->format($this->date());
        } catch (InvalidFormatException $th) {
            return null;
        }
    }
}
