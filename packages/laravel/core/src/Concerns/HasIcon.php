<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\IsIcon;

trait HasIcon
{
    /**
     * @var string|\Honed\Core\Contracts\IsIcon|null
     */
    protected $icon;

    /**
     * Set the icon for the instance.
     *
     * @return $this
     */
    public function icon(string|IsIcon|null $icon): static
    {
        if (! \is_null($icon)) {
            $this->icon = $icon;
        }

        return $this;
    }

    /**
     * Get the icon for the instance, evaluating it if necessary.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function getIcon($parameters = [], $typed = []): ?string
    {
        $evaluated = match (true) {
            $this->icon instanceof IsIcon => $this->icon->icon(),
            $parameters instanceof \Illuminate\Database\Eloquent\Model => $this->evaluateModelForIcon($parameters, 'getIcon'),
            default => $this->evaluate($this->icon, $parameters, $typed),
        };

        $this->icon = $evaluated;

        return $evaluated;
    }

    /**
     * Evaluate the icon for the instance.
     *
     * @param  array<string,mixed> $parameters
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
