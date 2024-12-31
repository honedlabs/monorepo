<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Icon;

trait HasIcon
{
    /**
     * @var string|Icon|null
     */
    protected $icon;

    /**
     * Set the icon, chainable.
     *
     * @return $this
     */
    public function icon(string|Icon $icon): static
    {
        $this->setIcon($icon);

        return $this;
    }

    /**
     * Set the icon, quietly.
     */
    public function setIcon(string|Icon|null $icon): void
    {
        if (\is_null($icon)) {
            return;
        }
        
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
    public function getIcon(): string|null
    {
        return $this->icon instanceof Icon ? $this->icon->icon() : $this->icon;
    }
}
