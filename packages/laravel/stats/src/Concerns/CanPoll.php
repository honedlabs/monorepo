<?php

declare(strict_types=1);

namespace Honed\Stat\Concerns;

trait CanPoll
{
    /**
     * Whether to poll for changes to the data.
     *
     * @var bool
     */
    protected $poll = false;

    /**
     * Set whether to poll for changes to the data.
     *
     * @return $this
     */
    public function poll(bool $value = true): static
    {
        $this->poll = $value;

        return $this;
    }

    /**
     * Set whether to not poll for changes to the data.
     *
     * @return $this
     */
    public function dontPoll(bool $value = true): static
    {
        return $this->poll(! $value);
    }

    /**
     * Determine whether the data is polling.
     */
    public function isPolling(): bool
    {
        return $this->poll;
    }

    /**
     * Determine whether the data is not polling.
     */
    public function isNotPolling(): bool
    {
        return ! $this->isPolling();
    }
}
