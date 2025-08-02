<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasItemHeight
{
    /**
     * The height of the items.
     * 
     * @var int|null
     */
    protected $itemHeight;

    /**
     * Set the height of the items.
     * 
     * @return $this
     */
    public function itemHeight(int $value): static
    {
        $this->itemHeight = $value;

        return $this;
    }

    /**
     * Get the height of the items.
     */
    public function getItemHeight(): ?int
    {
        return $this->itemHeight;
    }    
}