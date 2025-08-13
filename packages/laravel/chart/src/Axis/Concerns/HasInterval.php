<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait HasInterval
{
    /**
     * The segmentation interval value.
     *
     * @var int|null
     */
    protected $interval;

    /**
     * Set the segmentation interval value.
     *
     * @return $this
     */
    public function interval(int $value): static
    {
        $this->interval = $value;

        return $this;
    }

    /**
     * Get the segmentation interval value.
     */
    public function getInterval(): ?int
    {
        return $this->interval;
    }
}
