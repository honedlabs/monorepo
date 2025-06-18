<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\Exceptions\InvalidFormatException;

trait CanBeDateTime
{
    public const DATE = 'date';

    public const DATETIME = 'datetime';

    public const TIME = 'time';

    /**
     * Whether the value should be formatted as a date.
     *
     * @var bool
     */
    protected $isDate = false;

    /**
     * Whether the value should be formatted as a time.
     *
     * @var bool
     */
    protected $isTime = false;

    /**
     * Whether the value should be formatted as a date time.
     *
     * @var bool
     */
    protected $isDateTime = false;

    /**
     * The format to use for formatting dates.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d';

    /**
     * The format to use for formatting times.
     *
     * @var string
     */
    protected $timeFormat = 'H:i:s';

    /**
     * The format to use for formatting date times.
     *
     * @var string
     */
    protected $dateTimeFormat = 'Y-m-d H:i:s';

    /**
     * Whether to use Carbon's diffForHumans to format the date.
     *
     * @var bool
     */
    protected $isSince = false;

    /**
     * The timezone to use for formatting dates.
     *
     * @var string
     */
    protected $timezone = 'UTC';

    /**
     * Set whether the value should be formatted as a date.
     *
     * @param  bool  $date
     * @return $this
     */
    public function date($date = true)
    {
        $this->isDate = $date;

        $this->type(self::DATE);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date.
     *
     * @return bool
     */
    public function isDate()
    {
        return $this->isDate;
    }

    /**
     * Set whether the value should be formatted as a time.
     *
     * @param  bool  $time
     * @return $this
     */
    public function time($time = true)
    {
        $this->isTime = $time;

        $this->type(self::TIME);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a time.
     *
     * @return bool
     */
    public function isTime()
    {
        return $this->isTime;
    }

    /**
     * Set whether the value should be formatted as a date time.
     *
     * @param  bool  $dateTime
     * @return $this
     */
    public function dateTime($dateTime = true)
    {
        $this->isDateTime = $dateTime;

        $this->type(self::DATETIME);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date time.
     *
     * @return bool
     */
    public function isDateTime()
    {
        return $this->isDateTime;
    }

    /**
     * Set the format to use for formatting dates.
     *
     * @param  string  $format
     * @return $this
     */
    public function dateFormat($format)
    {
        $this->dateFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting dates.
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set the format to use for formatting times.
     *
     * @param  string  $format
     * @return $this
     */
    public function timeFormat($format)
    {
        $this->timeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting times.
     *
     * @return string
     */
    public function getTimeFormat()
    {
        return $this->timeFormat;
    }

    /**
     * Set the format to use for formatting date times.
     *
     * @param  string  $format
     * @return $this
     */
    public function dateTimeFormat($format)
    {
        $this->dateTimeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting date times.
     *
     * @return string
     */
    public function getDateTimeFormat()
    {
        return $this->dateTimeFormat;
    }

    /**
     * Set whether to use Carbon's diffForHumans to format the date.
     *
     * @param  bool  $since
     * @return $this
     */
    public function since($since = true)
    {
        $this->isSince = $since;

        return $this;
    }

    /**
     * Get whether to use Carbon's diffForHumans to format the date.
     *
     * @return bool
     */
    public function isSince()
    {
        return $this->isSince;
    }

    /**
     * Set the timezone to use for formatting dates.
     *
     * @param  string  $timezone
     * @return $this
     */
    public function timezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get the timezone to use for formatting dates.
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Format the value as a date.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    protected function formatDate($value)
    {
        return $this->formatCarbon($value, $this->getDateFormat());
    }

    /**
     * Format the value as a time.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    protected function formatTime($value)
    {
        return $this->formatCarbon($value, $this->getTimeFormat());
    }

    /**
     * Format the value as a date time.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    protected function formatDateTime($value)
    {
        return $this->formatCarbon($value, $this->getDateTimeFormat());
    }

    /**
     * Format the value as a date or time using Carbon and the given format.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     * @param  string  $format
     * @return string|null
     */
    protected function formatCarbon($value, $format)
    {
        if (is_null($value)) {
            return null;
        }

        if (! $value instanceof CarbonInterface) {
            $value = $this->newCarbon($value);
        }

        if ($this->isSince()) {
            return $value?->diffForHumans();
        }

        return $value
            ?->shiftTimezone($this->getTimezone())
            ->format($format);
    }

    /**
     * Attempt to parse the value as a Carbon instance.
     *
     * @param  string|int|float|null  $value
     * @return CarbonInterface|null
     */
    protected function newCarbon($value)
    {
        try {
            return Carbon::parse($value);
        } catch (InvalidFormatException $e) {
            return null;
        }
    }
}
