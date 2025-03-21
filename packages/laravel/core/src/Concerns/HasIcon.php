<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Icon;

trait HasIcon
{
    /**
     * The icon.
     *
     * @var string|\Honed\Core\Contracts\Icon|\Closure(mixed...):string|\Honed\Core\Contracts\Icon|null
     */
    protected $icon;

    /**
     * Set the icon.
     *
     * @param  string|\Honed\Core\Contracts\Icon|\Closure(mixed...):string|\Honed\Core\Contracts\Icon|null  $icon
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
        return match (true) {
            $this->icon instanceof Icon => $this->icon->icon(),
            $this->icon instanceof \Closure => $this->resolveIcon(),
            default => $this->icon,
        };
    }

    /**
     * Evaluate the icon.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|\Honed\Core\Contracts\Icon|null
     */
    public function resolveIcon($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->icon, $parameters, $typed);

        return $evaluated;
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
