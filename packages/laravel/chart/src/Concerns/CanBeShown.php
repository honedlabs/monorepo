<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait CanBeShown
{
    /**
     * Whether to show the axis.
     *
     * @var bool|null
     */
    protected $show;

    /**
     * Set whether to show the axis.
     *
     * @return $this
     */
    public function show(bool $value = true): static
    {
        $this->show = $value;

        return $this;
    }

    /**
     * Set whether to not show the axis.
     *
     * @return $this
     */
    public function dontShow(bool $value = true): static
    {
        return $this->show(! $value);
    }

    /**
     * Get whether to show the axis.
     */
    public function isShown(): ?bool
    {
        return $this->show;
    }

    /**
     * Get whether to not show the axis.
     */
    public function isNotShown(): bool
    {
        return ! $this->isShown();
    }
}
