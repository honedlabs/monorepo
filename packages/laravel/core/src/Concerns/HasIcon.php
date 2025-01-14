<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\IsIcon;

trait HasIcon
{
    use EvaluatesClosures {
        evaluateModelForTrait as evaluateModelForIcon;
    }

    /**
     * @var string|\Honed\Core\Contracts\IsIcon
     */
    protected $icon;

    /**
     * Set the icon for the instance.
     *
     * @param  string|\Honed\Core\Contracts\IsIcon|null  $icon
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
     * Determine if the instance has an icon set.
     */
    public function hasIcon(): bool
    {
        return isset($this->icon);
    }
}
