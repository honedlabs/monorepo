<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Carbon\Carbon;
use Honed\Core\Concerns\HasFormat;

class DateFormatter implements Contracts\Formatter
{
    use Concerns\HasDateFormat;
    use Concerns\HasTimezone;
    use Concerns\IsDifference;

    /**
     * Create a new date formatter instance with a format, difference, and timezone.
     * 
     * @param string|(\Closure():string)|null $format
     * @param bool|\Closure $diff
     * @param string|\Closure|null $timezone
     */
    public function __construct(string|\Closure|null $format = null, bool|\Closure $diff = false, string|\Closure|null $timezone = null)
    {
        $this->setDateFormat($format);
        $this->setDifference($diff);
        $this->setTimezone($timezone);
    }

    /**
     * Make a date formatter with a format, difference, and timezone.
     * 
     * @param string|(\Closure():string)|null $format
     * @param bool|\Closure $diff
     * @param string|\Closure|null $timezone
     * @return $this
     */
    public static function make(string|\Closure|null $format = null, bool|\Closure $diff = false, string|\Closure|null $timezone = null): self
    {
        return resolve(static::class, compact('format', 'diff', 'timezone'));
    }

    /**
     * Format the value as a string
     * 
     * @template T
     * @param T|mixed $value
     * @return T|string
     */
    public function format(mixed $value): string
    {
        try {
            return $this->isDifference() 
                ? Carbon::parse($value, $this->getTimezone())->diffForHumans()
                : Carbon::parse($value, $this->getTimezone())->format($this->getDateFormat());
        } catch (\Throwable $th) {
            dd($th);
            return $value;
        }
    }

    /**
     * Format the value as d M Y
     * 
     * @param string $separator
     * @return $this
     */
    public function dMY(string $separator = '/'): static
    {
        return $this->dateFormat("d{$separator}M{$separator}Y");
    }

    /**
     * Format the value as Y-m-d
     * 
     * @param string $separator
     * @return $this
     */
    public function Ymd(string $separator = '-'): static
    {
        return $this->dateFormat("Y{$separator}m{$separator}d");
    }
}
