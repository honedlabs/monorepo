<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTimezone
{
    /**
     * @var DateTimeZone|string|int|null
     */
    protected $timezone = null;

    /**
     * Set the timezone, chainable.
     *
     * @return $this
     */
    public function timezone(\DateTimeZone|string|int $timezone): static
    {
        $this->setTimezone($timezone);

        return $this;
    }

    /**
     * Set the timezone quietly.
     *
     * @param  DateTimeZone|string|int|null  $timezone
     */
    public function setTimezone(\DateTimeZone|string|int|null $timezone): void
    {
        if (is_null($timezone)) {
            return;
        }
        $this->timezone = $timezone;
    }

    /**
     * Get the timezone.
     *
     * @param  mixed  $parameter
     * @return \DateTimeZone|string|int|null
     */
    public function getTimezone($parameter = null): mixed
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
