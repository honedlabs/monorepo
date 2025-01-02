<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class DateFormatter implements Contracts\Formatter
{
    use Concerns\HasDateFormat;
    use Concerns\HasTimezone;
    use Concerns\IsDifference;

    /**
     * Create a new date formatter instance with a format, difference, and timezone.
     */
    public function __construct(string $format = null, bool $diff = false, string $timezone = null)
    {
        $this->setDateFormat($format);
        $this->setDifference($diff);
        $this->setTimezone($timezone);
    }

    /**
     * Make a date formatter with a format, difference, and timezone.
     */
    public static function make(string $format = null, bool $diff = false, string $timezone = null): static
    {
        return resolve(static::class, compact('format', 'diff', 'timezone'));
    }

    /**
     * Format the value as a string
     */
    public function format(mixed $value): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        try {
            return $this->isDifference()
                ? Carbon::parse($value, $this->getTimezone())->diffForHumans()
                : Carbon::parse($value, $this->getTimezone())->format($this->getDateFormat());
        } catch (InvalidFormatException $th) {
            return null; // Hide the error-causing value
        }
    }
}
