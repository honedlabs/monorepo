<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait CanBeShown
{
    /**
     * Whether to show the axis.
     *
     * @var ?bool
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
    public function dontShow(): static
    {
        return $this->show(false);
    }

    /**
     * Get whether to show the axis.
     */
    public function isShown(): ?bool
    {
        return $this->show;
    }
}
