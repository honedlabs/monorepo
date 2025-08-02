<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait CanBeSilent
{
    /**
     * Whether to ignore events.
     * 
     * @var bool|null
     */
    protected $silent;

    /**
     * Set whether to ignore events.
     * 
     * @param bool|null $value
     * @return $this
     */
    public function silent(?bool $value): static
    {
        $this->silent = $value;

        return $this;
    }

    /**
     * Set whether to not ignore events.
     * 
     * @return $this
     */
    public function notSilent(bool $value = true): static
    {
        return $this->silent(! $value);
    }

    /**
     * Get whether to ignore events.
     * 
     * @return true|null
     */
    public function isSilent(): ?bool
    {
        return $this->silent ?: null;
    }

    /**
     * Get whether to not ignore events.
     */
    public function isNotSilent(): bool
    {
        return ! $this->isSilent();
    }
}