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
     * Set the instance as active.
     *
     * @return $this
     */
    public function active(bool $active = true): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Set the instance as inactive.
     *
     * @return $this
     */
    public function inactive(bool $inactive = true): static
    {
        return $this->active(! $inactive);
    }

    /**
     * Determine if the instance is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
