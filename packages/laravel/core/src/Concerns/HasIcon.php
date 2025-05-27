<?php

namespace Honed\Core\Concerns;

trait HasIcon
{
    /**
     * The icon.
     *
     * @var string|(\Closure(...mixed):string)|null
     */
    protected $icon;

    /**
     * Set the icon.
     *
     * @param  string|\BackedEnum|\UnitEnum|null  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = match (true) {
            $icon instanceof \BackedEnum => $icon->value,
            $icon instanceof \UnitEnum => $icon->name,
            default => $icon
        };

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
        return isset($this->icon);
    }
}
