<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Style\ItemStyle;

trait HasItemStyle
{
    /**
     * The item style.
     * 
     * @var \Honed\Chart\Style\ItemStyle|null
     */
    protected $itemStyle;

    /**
     * Set the item style.
     * 
     * @param \Honed\Chart\Style\ItemStyle|(Closure(\Honed\Chart\Style\ItemStyle):mixed)|null $itemStyle
     * @return $this
     */
    public function itemStyle(ItemStyle|Closure|null $itemStyle): static
    {
        $this->itemStyle = $itemStyle instanceof Closure ? $itemStyle($this->withItemStyle()) : $itemStyle;

        return $this;
    }

    /**
     * Get the item style.
     * 
     * @return \Honed\Chart\Style\ItemStyle|null
     */
    public function getItemStyle(): ?ItemStyle
    {
        return $this->itemStyle;
    }

    /**
     * Create a new item style instance.
     */
    protected function withItemStyle(): ItemStyle
    {
        return $this->itemStyle ??= ItemStyle::make();
    }
}