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

    public function __construct(
        ?string $date = null,
        ?string $timezone = null,
        bool $diff = false
    ) {
        $this->date($date);
        $this->timezone($timezone);
        $this->since($diff);
    }

    /**
     * Make a new date formatter.
     */
    public static function make(
        ?string $date = null,
        ?string $timezone = null,
        bool $diff = false
    ): static {
        return resolve(static::class, compact('date', 'timezone', 'diff'));
    }

    /**
     * Set the date for the instance.
     *
     * @return $this
     */
    public function date(?string $date): static
    {
        if (! \is_null($date)) {
            $this->date = $date;
        }

        return $this;
    }

    /**
     * Get the date for the instance.
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Set the timezone for the instance.
     *
     * @return $this
     */
    public function timezone(?string $timezone): static
    {
        if (! \is_null($timezone)) {
            $this->timezone = $timezone;
        }

        return $this;
    }

    /**
     * Get the timezone for the instance.
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Determine if the instance has a timezone set.
     */
    public function hasTimezone(): bool
    {
        return ! \is_null($this->timezone);
    }

    /**
     * Set the instance to use diff for humans.
     *
     * @return $this
     */
    public function since(bool $since = true): static
    {
        $this->since = $since;

        return $this;
    }

    /**
     * Determine if the instance uses diff for humans.
     */
    public function isSince(): bool
    {
        return $this->since;
    }

    /**
     * Format the value as a date string.
     */
    public function format(mixed $value): ?string
    {
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
