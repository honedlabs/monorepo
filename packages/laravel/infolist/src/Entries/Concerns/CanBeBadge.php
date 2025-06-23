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
    protected $isBadge;

    /**
     * The variant of the badge.
     *
     * @var string|(Closure(mixed...): string)|null
     */
    protected $variant;

    /**
     * Set whether the entry should be displayed as a badge.
     *
     * @param  bool  $isBadge
     * @return $this
     */
    public function badge($isBadge = true)
    {
        $this->isBadge = $isBadge ?: null;

        return $this;
    }

    /**
     * Determine if the entry should be displayed as a badge.
     *
     * @return true|null
     */
    public function isBadge()
    {
        return $this->isBadge;
    }

    /**
     * Set the variant of the badge.
     *
     * @param  string|(Closure(mixed...): string)  $variant
     * @return $this
     */
    public function variant($variant)
    {
        $this->variant = $variant;

        return $this;
    }

    /**
     * Get the variant of the badge.
     *
     * @return string|null
     */
    public function getVariant()
    {
        if (! $this->isBadge()) {
            return null;
        }

        /** @var string|null */
        return $this->evaluate($this->variant);
    }
}
