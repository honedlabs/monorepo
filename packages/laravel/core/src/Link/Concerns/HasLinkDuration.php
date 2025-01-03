<?php

declare(strict_types=1);

namespace Honed\Core\Link\Concerns;

use Carbon\Carbon;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasLinkDuration
{
    /**
     * @var int|\Carbon\Carbon
     */
    protected $linkDuration = 0;

    /**
     * Set the duration, chainable.
     *
     * @return $this
     */
    public function linkDuration(int|Carbon|null $duration): static
    {
        $this->setLinkDuration($duration);

        return $this;
    }

    /**
     * Set the duration quietly.
     */
    public function setLinkDuration(int|Carbon|null $duration): void
    {
        if (is_null($duration)) {
            return;
        }
        $this->linkDuration = $duration;
    }

    /**
     * Get the duration.
     */
    public function getLinkDuration(): int|Carbon|null
    {
        return $this->linkDuration;
    }

    /**
     * Determine if the url is temporary.
     */
    public function isTemporary(): bool
    {
        return (bool) $this->getLinkDuration() > 0;
    }
}
