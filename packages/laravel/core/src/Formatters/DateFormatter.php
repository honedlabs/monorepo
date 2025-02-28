<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Honed\Core\Contracts\Formats;

class DateFormatter implements Formats
{
    /**
     * @var string
     */
    protected $date = 'd/m/Y';

    /**
     * @var string|null
     */
    protected $timezone = null;

    /**
     * @var bool
     */
    protected $since = false;

    /**
     * Make a new date formatter.
     *
     * @param  string|null  $date
     * @param  string|null  $timezone
     * @param  bool  $diff
     * @return static
     */
    public static function make($date = null, $timezone = null, $diff = false)
    {
        return resolve(static::class)
            ->date($date)
            ->timezone($timezone)
            ->since($diff);
    }

    /**
     * Set the date for the instance.
     *
     * @param  string|null  $date
     * @return $this
     */
    public function date($date = null)
    {
        if (! \is_null($date)) {
            $this->date = $date;
        }

        return $this;
    }

    /**
     * Get the date for the instance.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the timezone for the instance.
     *
     * @param  string|null  $timezone
     * @return $this
     */
    public function timezone($timezone = null)
    {
        if (! \is_null($timezone)) {
            $this->timezone = $timezone;
        }

        return $this;
    }

    /**
     * Get the timezone for the instance.
     *
     * @return string|null
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Determine if the instance has a timezone set.
     *
     * @return bool
     */
    public function hasTimezone()
    {
        return ! \is_null($this->timezone);
    }

    /**
     * Set the instance to use diff for humans.
     *
     * @param  bool  $since
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
     * @return bool
     */
    public function isSince()
    {
        return $this->since;
    }

    /**
     * Format the value as a date string.
     *
     * @param  mixed  $value
     * @return string|null
     */
    public function format($value)
    {
        /** @var string|null $value */
        if (\is_null($value)) {
            return null;
        }

        try {
            return $this->isSince()
                ? Carbon::parse($value, $this->getTimezone())->diffForHumans()
                : Carbon::parse($value, $this->getTimezone())->format($this->getDate());
        } catch (InvalidFormatException $th) {
            return null;
        }
    }
}
