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
     * @return $this
     */
    public function icon(string|Iconable|\Closure|null $icon): static
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
     */
    public function resolveIcon(array $parameters = [], array $typed = []): ?string
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->icon, $parameters, $typed);

        $this->icon = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has an icon set.
     */
    public function hasIcon(): bool
    {
        return ! \is_null($this->icon);
    }
}
