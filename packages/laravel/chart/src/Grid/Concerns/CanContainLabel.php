<?php

declare(strict_types=1);

namespace Honed\Chart\Grid\Concerns;

trait CanContainLabel
{
    /**
     * Whether the grid region should contain the axis label of the tick.
     *
     * @var bool
     */
    protected $containLabel = false;

    /**
     * Set whether the grid region should contain the axis label of the tick.
     *
     * @return $this
     */
    public function containLabel(bool $value = true): static
    {
        $this->containLabel = $value;

        return $this;
    }

    /**
     * Set whether the grid region should not contain the axis label of the tick.
     *
     * @return $this
     */
    public function dontContainLabel(bool $value = true): static
    {
        return $this->containLabel(! $value);
    }

    /**
     * Get whether the grid region should contain the axis label of the tick.
     *
     * @return true|null
     */
    public function isContainingLabel(): ?bool
    {
        return $this->containLabel ?: null;
    }

    /**
     * Get whether the grid region should not contain the axis label of the tick.
     */
    public function isNotContainingLabel(): bool
    {
        return ! $this->isContainingLabel();
    }
}
