<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasItemWidth
{
    /**
     * The width of the items.
     *
     * @var int|null
     */
    protected $itemWidth;

    /**
     * Set the width of the items.
     *
     * @return $this
     */
    public function itemWidth(int $value): static
    {
        $this->itemWidth = $value;

        return $this;
    }

    /**
     * Get the width of the items.
     */
    public function getItemWidth(): ?int
    {
        return $this->itemWidth;
    }
}
