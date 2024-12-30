<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

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
    public function setIcon(string|null $icon): void
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
    public function getIcon(): string|null
    {
        return $this->icon;
    }
}
