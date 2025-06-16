<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Closure;

trait CanBeBadge
{
    /**
     * Whether the entry should be displayed as a badge.
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
     */
    public function isBadge(): bool
    {
        return (bool) $this->isBadge;
    }

    /**
     * Set the variant of the badge.
     *
     * @param  string|(Closure(mixed...): string)  $variant
     * @return $this
     */
    public function variant(string|Closure $variant): static
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

    /**
     * Determine if a variant is set.
     */
    public function hasVariant(): bool
    {
        return isset($this->variant);
    }
}
