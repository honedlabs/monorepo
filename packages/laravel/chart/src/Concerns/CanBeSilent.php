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
     * Get whether to ignore events.
     * 
     * @return true|null
     */
    public function isSilent(): ?bool
    {
        return $this->silent ?: null;
    }
}