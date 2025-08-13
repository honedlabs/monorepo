<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasItemGap
{
    /**
     * The distance two items in pixels.
     *
     * @var int|null
     */
    protected $itemGap;

    /**
     * Set the distance two items in pixels.
     *
     * @return $this
     */
    public function itemGap(int $value): static
    {
        $this->itemGap = $value;

        return $this;
    }

    /**
     * Get the distance two items in pixels.
     */
    public function getItemGap(): ?int
    {
        return $this->itemGap;
    }
}
