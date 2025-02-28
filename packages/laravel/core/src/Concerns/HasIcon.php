<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Iconable;

trait HasIcon
{
    /**
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
        if (! \is_null($icon)) {
            $this->icon = $icon;
        }

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
     * @param  array<string,mixed>  $typed
     * @return string|\Honed\Core\Contracts\Iconable|null
     */
    public function resolveIcon($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->icon, $parameters, $typed);

        $this->icon = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has an icon set.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return ! \is_null($this->icon);
    }
}
