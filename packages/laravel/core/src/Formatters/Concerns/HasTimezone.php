<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTimezone
{
    /**
     * @var \DateTimeZone|string|int|null|(\Closure(): \DateTimeZone|string|int|null)
     */
    protected $timezone = null;

    /**
     * Set the timezone, chainable.
     *
     * @param  \DateTimeZone|string|int|(\Closure(): \DateTimeZone|string|int)  $timezone
     * @return $this
     */
    public function timezone(mixed $timezone): static
    {
        $this->setTimezone($timezone);

        return $this;
    }

    /**
     * Set the timezone quietly.
     *
     * @param  \DateTimeZone|string|int|null|(\Closure(): \DateTimeZone|string|int)  $timezone
     */
    public function setTimezone(mixed $timezone): void
    {
        if (is_null($timezone)) {
            return;
        }
        $this->timezone = $timezone;
    }

    /**
     * Get the timezone.
     *
     * @return \DateTimeZone|string|int|null
     */
    public function getTimezone(mixed $parameter = null): mixed
    {
        return value($this->timezone, $parameter);
    }

    /**
     * Determine if the class does not have a timezone.
     */
    public function missingTimezone(): bool
    {
        return \is_null($this->timezone);
    }

    /**
     * Determine if the class has a timezone.
     */
    public function hasTimezone(): bool
    {
        return ! $this->missingTimezone();
    }
}
