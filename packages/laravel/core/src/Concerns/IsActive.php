<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsActive
{
    /**
     * @var bool
     */
    protected $active = false;

    /**
     * Set the active property, chainable.
     *
     * @return $this
     */
    public function active(bool $active = true): static
    {
        $this->setActive($active);

        return $this;
    }

    /**
     * Set the active property quietly.
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * Determine if the class is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
