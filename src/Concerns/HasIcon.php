<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasIcon
{
    /**
     * @var string|\Closure():string|null
     */
    protected $icon;

    /**
     * Set the icon, chainable.
     *
     * @param  string|\Closure():string|null  $icon
     * @return $this
     */
    public function icon(string|\Closure $icon): static
    {
        $this->setIcon($icon);

        return $this;
    }

    /**
     * Set the icon, quietly.
     *
     * @param  string|\Closure():string|null  $icon
     */
    public function setIcon(string|\Closure|null $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * Determine if the instance has an icon.
     */
    public function hasIcon(): bool
    {
        return ! \is_null($this->icon);
    }

    /**
     * Get the icon.
     */
    public function getIcon(): ?string
    {
        return value($this->icon);
    }
}
