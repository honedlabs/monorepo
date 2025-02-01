<?php

declare(strict_types=1);

namespace Honed\Nav\Concerns;

use Honed\Nav\NavGroup;
use Honed\Nav\NavItem;

trait HasNavItems
{
    /**
     * @var array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>|null
     */
    protected $items;

    /**
     * Set the navigation items.    
     * 
     * @param  array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>  $items
     * 
     * @return $this
     */
    public function items(...$items): static
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Append a navigation item to the instance.
     * 
     * @param  \Honed\Nav\NavItem|\Honed\Nav\NavGroup  $item
     * 
     * @return $this
     */
    public function add(NavItem|NavGroup $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Get the navigation items.
     * 
     * @return array<int,\Honed\Nav\NavItem|\Honed\Nav\NavGroup>
     */

    public function getItems(): array
    {
        return $this->items ?? [];
    }

    /**
     * Determine if the instance has navigation items.
     */
    public function hasItems(): bool
    {
        return ! \is_null($this->items);
    }
}