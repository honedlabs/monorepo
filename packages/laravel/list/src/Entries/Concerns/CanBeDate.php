<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

trait CanBeDate
{
    /**
     * Whether the value should be formatted as a date.
     * 
     * @var bool
     */
    protected bool $isDate = false;

    /**
     * Whether the value should be formatted as a time.
     * 
     * @var bool
     */
    protected bool $isTime = false;

    /**
     * Whether the value should be formatted as a date time.
     * 
     * @var bool
     */
    protected bool $isDateTime = false;

    /**
     * The format to use for formatting dates.
     * 
     * @var string
     */
    protected string $dateFormat = 'Y-m-d';

    /**
     * The format to use for formatting times.
     * 
     * @var string
     */
    protected string $timeFormat = 'H:i:s';

    /**
     * The format to use for formatting date times.
     * 
     * @var string
     */
    protected string $dateTimeFormat = 'Y-m-d H:i:s';

    /**
     * Whether to use Carbon's diffForHumans to format the date.
     * 
     * @var bool
     */
    protected bool $isSince = false;

    /**
     * Set whether the value should be formatted as a date.
     * 
     * @param  bool  $date
     * @return $this
     */
    public function date(bool $date = true): static
    {
        $this->isDate = $date;

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date.
     * 
     * @return bool
     */
    public function isDate(): bool
    {
        return $this->isDate;
    }

    /**
     * Set whether the value should be formatted as a time.
     * 
     * @param  bool  $time
     * @return $this
     */
    public function time(bool $time = true): static
    {
        $this->isTime = $time;

        return $this;
    }

    /**
     * Get whether the value should be formatted as a time.
     * 
     * @return bool
     */
    public function isTime(): bool
    {
        return $this->isTime;
    }

    /**
     * Set whether the value should be formatted as a date time.
     * 
     * @param  bool  $dateTime
     * @return $this
     */
    public function dateTime(bool $dateTime = true): static
    {
        $this->isDateTime = $dateTime;

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date time.
     * 
     * @return bool
     */
    public function isDateTime(): bool
    {
        return $this->isDateTime;
    }

    /**
     * Set the format to use for formatting dates.
     * 
     * @param  string  $format
     * @return $this
     */
    public function dateFormat(string $format): static
    {
        $this->dateFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting dates.
     * 
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Set the format to use for formatting times.
     * 
     * @param  string  $format
     * @return $this
     */
    public function timeFormat(string $format): static
    {
        $this->timeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting times.
     * 
     * @return string
     */
    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }

    /**
     * Set the format to use for formatting date times.
     * 
     * @param  string  $format
     * @return $this
     */
    public function dateTimeFormat(string $format): static
    {
        $this->dateTimeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting date times.
     * 
     * @return string
     */
    public function getDateTimeFormat(): string
    {
        return $this->dateTimeFormat;
    }

    /**
     * Set whether to use Carbon's diffForHumans to format the date.
     * 
     * @param  bool  $isSince
     * @return $this
     */
    public function since(bool $since = true): static
    {
        $this->isSince = $since;

        return $this;
    }

    /**
     * Get whether to use Carbon's diffForHumans to format the date.
     * 
     * @return bool
     */
    public function isSince(): bool
    {
        return $this->isSince;
    }
}