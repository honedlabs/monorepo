<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

use Carbon\Carbon;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasUrlDuration
{
    /**
     * @var int|\Carbon\Carbon
     */
    protected $urlDuration = 0;

    /**
     * Set the duration, chainable.
     *
     * @return $this
     */
    public function urlDuration(int|Carbon|null $duration): static
    {
        $this->setUrlDuration($duration);

        return $this;
    }

    /**
     * Set the duration quietly.
     */
    public function setUrlDuration(int|Carbon|null $duration): void
    {
        if (is_null($duration)) {
            return;
        }
        $this->urlDuration = $duration;
    }

    /**
     * Get the duration.
     */
    public function getUrlDuration(): int|Carbon|null
    {
        return $this->urlDuration;
    }

    /**
     * Determine if the url is temporary.
     */
    public function isTemporary(): bool
    {
        return (bool) $this->getUrlDuration() > 0;
    }
}
