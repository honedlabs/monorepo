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
     * @param \Honed\Chart\Style\ItemStyle|(Closure(\Honed\Chart\Style\ItemStyle):\Honed\Chart\Style\ItemStyle)|null $value
     * @return $this
     */
    public function itemStyle(ItemStyle|Closure|null $value = null): static
    {
        $this->itemStyle = match (true) {
            is_null($value) => $this->withItemStyle(),
            $value instanceof Closure => $value($this->withItemStyle()),
            default => $this->itemStyle = $value,
        };

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