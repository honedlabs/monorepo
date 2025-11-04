<?php

declare(strict_types=1);

namespace Honed\Infolist\Formatters\Support;

use Carbon\CarbonInterface;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

/**
 * @extends LocalisedFormatter<\Carbon\CarbonInterface|string|int|float, string>
 */
abstract class CarbonFormatter extends LocalisedFormatter
{
    /**
     * The format to use for formatting a carbon instance.
     *
     * @var string
     */
    protected $using = 'Y-m-d H:i:s';

    /**
     * Whether to use Carbon's diffForHumans to format the date.
     *
     * @var bool
     */
    protected $since = false;

    /**
     * The timezone to use for formatting dates.
     *
     * @var ?string
     */
    protected $timezone;

    /**
     * Set the format to use for formatting a carbon instance.
     *
     * @return $this
     */
    public function using(string $value): static
    {
        $this->using = $value;

        return $this;
    }

    /**
     * Get the format to use for formatting a carbon instance.
     */
    public function getDateFormat(): string
    {
        return $this->using;
    }

    /**
     * Set whether to use Carbon's diffForHumans to format the date.
     *
     * @return $this
     */
    public function since(bool $value = true): static
    {
        $this->since = $value;

        return $this;
    }

    /**
     * Get whether to use Carbon's diffForHumans to format the date.
     */
    public function isSince(): bool
    {
        return $this->since;
    }

    /**
     * Set the timezone to use for formatting dates.
     *
     * @return $this
     */
    public function timezone(?string $value): static
    {
        $this->timezone = $value;

        return $this;
    }

    /**
     * Get the timezone to use for formatting dates.
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Format the value as a formatted carbon instance.
     *
     * @param  CarbonInterface|string|int|float|null  $value
     * @return string|null
     */
    public function format(mixed $value): mixed
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

        if ($tz = $this->getTimezone()) {
            $value = $value?->setTimezone($tz);
        }

        return $value // @phpstan-ignore-line method.nonObject
            ?->locale($this->getLocale())
            ->translatedFormat($this->getDateFormat());
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
