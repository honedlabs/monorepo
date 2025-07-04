<?php

declare(strict_types=1);

namespace Honed\Stats\Concerns;

trait CanGroup
{
    /**
     * Whether to group the data.
     *
     * @var bool|string
     */
    protected $group = false;

    /**
     * Set whether to group the data.
     *
     * @return $this
     */
    public function group(bool|string $value = true): static
    {
        $this->group = $value;

        return $this;
    }

    /**
     * Set whether to not group the data.
     *
     * @return $this
     */
    public function dontGroup(bool $value = true): static
    {
        return $this->group(! $value);
    }

    /**
     * Determine whether the data is grouped.
     */
    public function isGrouped(): bool
    {
        return (bool) $this->group;
    }

    /**
     * Determine whether the data is not grouped.
     */
    public function isNotGrouped(): bool
    {
        return ! $this->isGrouped();
    }
}
