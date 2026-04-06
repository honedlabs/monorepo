<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\ItemStyle;

trait HasItemStyle
{
    /**
     * The area style.
     *
     * @var ?ItemStyle
     */
    protected $itemStyleInstance;

    /**
     * Set the area style.
     *
     * @param  ItemStyle|(Closure(ItemStyle):ItemStyle)|bool|null  $value
     * @return $this
     */
    public function itemStyle(ItemStyle|Closure|bool|null $value = true): static
    {
        $this->itemStyleInstance = match (true) {
            $value => $this->withItemStyle(),
            ! $value => null,
            $value instanceof Closure => $value($this->withItemStyle()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the area style.
     */
    public function getItemStyle(): ?ItemStyle
    {
        return $this->itemStyleInstance;
    }

    /**
     * Create a new area style instance.
     */
    protected function withItemStyle(): ItemStyle
    {
        return $this->itemStyleInstance ??= ItemStyle::make();
    }
}
