<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;
use Closure;

trait CanHaveIcon
{
    /**
     * The icon of the instance.
     *
     * @var string|BackedEnum|(Closure():string)|null
     */
    protected $icon;

    /**
     * Set the icon.
     *
     * @param  string|Closure():string|BackedEnum|null  $icon
     * @return $this
     */
    public function icon(string|Closure|BackedEnum|null $icon): static
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
