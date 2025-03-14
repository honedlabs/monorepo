<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Iconable;

trait HasIcon
{
    /**
     * The icon for the instance.
     *
     * @var string|\Honed\Core\Contracts\Iconable|\Closure|null
     */
    protected $icon;

    /**
     * Set the icon for the instance.
     *
     * @param  string|Iconable|\Closure|null  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the icon for the instance.
     *
     * @return string|null
     */
    public function getIcon()
    {
        return match (true) {
            $this->icon instanceof Iconable => $this->icon->icon(),
            $this->icon instanceof \Closure => $this->resolveIcon(),
            default => $this->icon,
        };
    }

    /**
     * Evaluate the icon for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|\Honed\Core\Contracts\Iconable|null
     */
    public function resolveIcon($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->icon, $parameters, $typed);

        return $evaluated;
    }

    /**
     * Determine if the instance has an icon set.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return isset($this->icon);
    }
}
