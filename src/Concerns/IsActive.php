<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsActive
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $active = false;

    /**
     * Set the active property, chainable.
     *
     * @param  bool|(\Closure():bool)  $active
     * @return $this
     */
    public function active(bool|\Closure $active = true): static
    {
        $this->setActive($active);

        return $this;
    }

    /**
     * Set the active property quietly.
     *
     * @param  bool|(\Closure():bool)|null  $active
     */
    public function setActive(bool|\Closure|null $active): void
    {
        if (is_null($active)) {
            return;
        }
        $this->active = $active;
    }

    /**
     * Determine if the class is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->evaluate($this->active);
    }

    /**
     * Determine if the class is not active.
     */
    public function isNotActive(): bool
    {
        return ! $this->isActive();
    }
}
