<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait CanBeInside
{
    /**
     * Whether the axis labels face the inside direction.
     *
     * @var bool
     */
    protected $inside = false;

    /**
     * Set whether the axis labels face the inside direction.
     *
     * @return $this
     */
    public function inside(bool $value = true): static
    {
        $this->inside = $value;

        return $this;
    }

    /**
     * Set whether the axis labels do not face the inside direction.
     *
     * @return $this
     */
    public function notInside(bool $value = true): static
    {
        return $this->inside(! $value);
    }

    /**
     * Get whether the axis labels face the inside direction.
     *
     * @return true|null
     */
    public function isInside(): ?bool
    {
        return $this->inside ?: null;
    }

    /**
     * Get whether the axis labels do not face the inside direction.
     */
    public function isNotInside(): bool
    {
        return ! $this->isInside();
    }
}
