<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\HasIcon as HasIconContract;

trait HasIcon
{
    /**
     * The icon.
     *
     * @var string|\Honed\Core\Contracts\Icon|\Closure(...mixed):string|\Honed\Core\Contracts\Icon|null
     */
    protected $icon;

    /**
     * Set the icon.
     *
     * @param  string|\Honed\Core\Contracts\Icon|\Closure(...mixed):string|\Honed\Core\Contracts\Icon|null  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Define the icon.
     *
     * @return string|\Honed\Core\Contracts\Icon|(\Closure(...mixed):string|\Honed\Core\Contracts\Icon)|null
     */
    public function defineIcon()
    {
        return null;
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
        $icon = $this->icon ??= $this->defineIcon();

        if ($icon instanceof HasIconContract) {
            return $icon->icon();
        }

        return $this->evaluate($icon, $parameters, $typed);
    }

    /**
     * Determine if an icon is set.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return filled($this->getIcon());
    }
}
