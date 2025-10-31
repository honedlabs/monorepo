<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;

trait HasTarget
{
    /**
     * The target for the URL
     *
     * @var string|Closure():string|null
     */
    protected $target;

    /**
     * Set the target for the URL.
     *
     * @param  string|Closure():string|null  $target
     * @return $this
     */
    public function target(string|Closure|null $target): static
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Open the URL in a new tab.
     *
     * @return $this
     */
    public function openUrlInNewTab(): static
    {
        return $this->target('_blank');
    }

    /**
     * Get the target for the URL.
     */
    public function getTarget(): ?string
    {
        return $this->evaluate($this->target);
    }
}
