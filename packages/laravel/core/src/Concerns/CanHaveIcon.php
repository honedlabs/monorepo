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
     * @return string|null
     */
    public function getIcon()
    {
        return $this->evaluate($this->icon);
    }

    /**
     * Determine if an icon is set.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return isset($this->icon);
    }
}
