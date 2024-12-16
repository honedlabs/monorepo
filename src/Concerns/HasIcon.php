<?php

namespace Honed\Crumb\Concerns;

trait HasIcon
{
    /**
     * @var string|null
     */
    protected $icon;

    /**
     * Set the icon, chainable.
     *
     * @return $this
     */
    public function icon(string $icon): static
    {
        $this->setIcon($icon);

        return $this;
    }

    /**
     * Set the icon, quietly.
     */
    public function setIcon(?string $icon): void
    {
        if (is_null($icon)) {
            return;
        }

        $this->icon = $icon;
    }

    /**
     * Determine if the nav item has no icon.
     */
    public function missingIcon(): bool
    {
        return \is_null($this->icon);
    }

    /**
     * Determine if the nav item has an icon.
     */
    public function hasIcon(): bool
    {
        return ! $this->missingIcon();
    }

    /**
     * Get the icon.
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }
}