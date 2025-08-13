<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait Zeroable
{
    /**
     * Whether the axis lines on the other's origin position.
     *
     * @var bool
     */
    protected $onZero = true;

    /**
     * When multiple axes exists, this option can be used to specify which axis.
     *
     * @var int|null
     */
    protected $onZeroAxisIndex;

    /**
     * Set whether the axis lines on the other's origin position.
     *
     * @return $this
     */
    public function onZero(bool $value = true): static
    {
        $this->onZero = $value;

        return $this;
    }

    /**
     * Set whether the axis lines do not on the other's origin position.
     *
     * @return $this
     */
    public function notOnZero(bool $value = true): static
    {
        return $this->onZero(! $value);
    }

    /**
     * Get whether the axis lines on the other's origin position.
     */
    public function isOnZero(): bool
    {
        return $this->onZero;
    }

    /**
     * Get whether the axis lines do not on the other's origin position.
     */
    public function isNotOnZero(): bool
    {
        return ! $this->onZero;
    }

    /**
     * Set the axis index to be on zero.
     *
     * @return $this
     */
    public function onZeroAxisIndex(int $value): static
    {
        $this->onZeroAxisIndex = $value;

        return $this;
    }

    /**
     * Get the axis index to be on zero.
     */
    public function getOnZeroAxisIndex(): ?int
    {
        return $this->onZeroAxisIndex;
    }
}
