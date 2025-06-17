<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Closure;

trait CanBeBadge
{
    /**
     * Whether the entry should be displayed as a badge.
     *
     * @var true|null
     */
    protected ?bool $isBadge = null;

    /**
     * The variant of the badge.
     *
     * @var string|(Closure(mixed...): string)|null
     */
    protected string|Closure|null $variant = null;

    /**
     * Set whether the entry should be displayed as a badge.
     *
     * @return $this
     */
    public function badge(bool $isBadge = true): static
    {
        $this->isBadge = $isBadge ?: null;

        return $this;
    }

    /**
     * Determine if the entry should be displayed as a badge.
     *
     * @return true|null
     */
    public function isBadge(): ?bool
    {
        return $this->isBadge;
    }

    /**
     * Set the variant of the badge.
     *
     * @param  string|(Closure(mixed...): string)  $variant
     * @return $this
     */
    public function variant(string|Closure|null $variant): static
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Get the variant of the badge.
     */
    public function getVariant(): ?string
    {
        if (! $this->isBadge()) {
            return null;
        }

        /** @var string|null */
        return $this->evaluate($this->variant);
    }
}
