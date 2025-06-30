<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;

trait CanHaveIcon
{
    /**
     * The icon of the instance.
     *
     * @var string|(\Closure(...mixed):string)|null
     */
    protected string|BackedEnum|null $icon = null;

    /**
     * Set the icon.
     *
     * @return $this
     */
    public function icon(string|BackedEnum|null $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the icon.
     */
    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon);
    }

    /**
     * Determine if an icon is set.
     */
    public function hasIcon(): bool
    {
        return isset($this->icon);
    }
}
