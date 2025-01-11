<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\IsIcon;

trait HasIcon
{
    /**
     * @var string|\Honed\Core\Contracts\IsIcon
     */
    protected $icon;

    /**
     * Set the icon for the instance.
     * 
     * @param string|\Honed\Core\Contracts\IsIcon|null $icon
     * @return $this
     */
    public function icon($icon): static
    {
        if (! \is_null($icon)) {
            $this->icon = $icon;
        }

        return $this;
    }

    /**
     * Get the icon for the instance.
     */
    public function getIcon(): ?string
    {
        return $this->icon instanceof IsIcon ? $this->icon->icon() : $this->icon;
    }

    /**
     * Determine if the instance has an icon set.
     */
    public function hasIcon(): bool
    {
        return isset($this->icon);
    }
}
