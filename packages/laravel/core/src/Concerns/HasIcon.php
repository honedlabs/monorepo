<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use BackedEnum;

trait HasIcon
{
    /**
     * The icon of the instance.
     *
     * @var string|(\Closure(...mixed):string)|null
     */
    protected $icon;

    /**
     * Set the icon.
     *
     * @param  string|BackedEnum|null  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the icon.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function getIcon($parameters = [], $typed = [])
    {
        return $this->evaluate($this->icon, $parameters, $typed);
    }

    /**
     * Determine if an icon is set.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return filled($this->icon);
    }
}
