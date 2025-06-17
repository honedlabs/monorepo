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
     */
    protected bool $isDate = false;

    /**
     * Whether the value should be formatted as a time.
     */
    protected bool $isTime = false;

    /**
     * Whether the value should be formatted as a date time.
     */
    protected bool $isDateTime = false;

    /**
     * The format to use for formatting dates.
     */
    protected string $dateFormat = 'Y-m-d';

    /**
     * The format to use for formatting times.
     */
    protected string $timeFormat = 'H:i:s';

    /**
     * The format to use for formatting date times.
     */
    protected string $dateTimeFormat = 'Y-m-d H:i:s';

    /**
     * Whether to use Carbon's diffForHumans to format the date.
     */
    protected bool $isSince = false;

    /**
     * The timezone to use for formatting dates.
     */
    protected string $timezone = 'UTC';

    /**
     * Set whether the value should be formatted as a date.
     *
     * @return $this
     */
    public function date(bool $date = true): static
    {
        $this->isDate = $date;

        $this->type(self::DATE);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date.
     */
    public function isDate(): bool
    {
        return $this->isDate;
    }

    /**
     * Set whether the value should be formatted as a time.
     *
     * @return $this
     */
    public function time(bool $time = true): static
    {
        $this->isTime = $time;

        $this->type(self::TIME);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a time.
     */
    public function isTime(): bool
    {
        return $this->isTime;
    }

    /**
     * Set whether the value should be formatted as a date time.
     *
     * @return $this
     */
    public function dateTime(bool $dateTime = true): static
    {
        $this->isDateTime = $dateTime;

        $this->type(self::DATETIME);

        return $this;
    }

    /**
     * Get whether the value should be formatted as a date time.
     */
    public function isDateTime(): bool
    {
        return $this->isDateTime;
    }

    /**
     * Set the format to use for formatting dates.
     *
     * @return $this
     */
    public function dateFormat(string $format): static
    {
        $this->dateFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting dates.
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Set the format to use for formatting times.
     *
     * @return $this
     */
    public function timeFormat(string $format): static
    {
        $this->timeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting times.
     */
    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }

    /**
     * Set the format to use for formatting date times.
     *
     * @return $this
     */
    public function dateTimeFormat(string $format): static
    {
        $this->dateTimeFormat = $format;

        return $this;
    }

    /**
     * Get the format to use for formatting date times.
     */
    public function getDateTimeFormat(): string
    {
        return $this->dateTimeFormat;
    }

    /**
     * Set whether to use Carbon's diffForHumans to format the date.
     *
     * @return $this
     */
    public function since(bool $since = true): static
    {
        $this->isSince = $since;

        return $this;
    }

    /**
     * Get whether to use Carbon's diffForHumans to format the date.
     */
    public function isSince(): bool
    {
        return $this->isSince;
    }

    /**
     * Set the timezone to use for formatting dates.
     *
     * @return $this
     */
    public function timezone(string $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get the timezone to use for formatting dates.
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * Format the value as a date.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     */
    protected function formatDate(mixed $value): ?string
    {
        return $this->formatCarbon($value, $this->getDateFormat());
    }

    /**
     * Format the value as a time.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     */
    protected function formatTime(mixed $value): ?string
    {
        return $this->formatCarbon($value, $this->getTimeFormat());
    }

    /**
     * Format the value as a date time.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     */
    protected function formatDateTime(mixed $value): ?string
    {
        return $this->formatCarbon($value, $this->getDateTimeFormat());
    }

    /**
     * Format the value as a date or time using Carbon and the given format.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     */
    protected function formatCarbon(mixed $value, string $format): ?string
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
     */
    protected function newCarbon(mixed $value): ?CarbonInterface
    {
        try {
            return Carbon::parse($value);
        } catch (InvalidFormatException $e) {
            return null;
        }
    }
}
