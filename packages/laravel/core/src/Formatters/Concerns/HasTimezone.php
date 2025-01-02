<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

use DateTimeZone;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasTimezone
{
    /**
     * @var \DateTimeZone|string|int|null
     */
    protected $timezone = null;

    /**
     * Set the timezone, chainable.
     *
     * @return $this
     */
    public function timezone(DateTimeZone|string|int $timezone): static
    {
        $this->setTimezone($timezone);

        return $this;
    }

    /**
     * Set the timezone quietly.
     */
    public function setTimezone(DateTimeZone|string|int|null $timezone): void
    {
        if (\is_null($timezone)) {
            return;
        }

        $this->timezone = $timezone;
    }

    /**
     * Get the timezone.
     */
    public function getTimezone(): DateTimeZone|string|int|null
    {
        return $this->timezone;
    }

    /**
     * Determine if the class has a timezone.
     */
    public function hasTimezone(): bool
    {
        return ! \is_null($this->timezone);
    }
}
