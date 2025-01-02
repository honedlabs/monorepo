<?php

declare(strict_types=1);

namespace Honed\Core\Formatters;

use Honed\Core\Concerns\HasLocale;
use Illuminate\Support\Number;

class NumberFormatter implements Contracts\Formatter
{
    use Concerns\HasDivideBy;
    use Concerns\HasPrecision;
    use HasLocale;

    /**
     * Create a new number formatter instance with a precision, divide by, and rounding.
     */
    public function __construct(int $precision = null, int $divideBy = null, string $locale = null)
    {
        $this->setPrecision($precision);
        $this->setDivideBy($divideBy);
        $this->setLocale($locale);
    }

    /**
     * Make a number formatter with a precision, divide by, and rounding.
     * 
     * @return $this
     */
    public static function make(int $precision = null, int $divideBy = null, string $locale = null): static
    {
        return resolve(static::class, compact('precision', 'divideBy', 'locale'));
    }

    /**
     * Format the value as a number
     */
    public function format(mixed $value): string|null|false
    {
        if (\is_null($value) || ! \is_numeric($value)) {
            return null;
        }

        $value = (float) $value;
        $value = $this->hasDivideBy() ? $value / $this->getDivideBy() : $value;

        return Number::format($value, precision: $this->getPrecision(), locale: $this->getLocale());
    }
}
