<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsDefault
{
    /**
     * @var bool
     */
    protected $default = false;

    /**
     * Set the instance as the default.
     *
     * @return $this
     */
    public function default(bool $default = true): static
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Determine if the instance is the default.
     */
    public function isDefault(): bool
    {
        return $this->default;
    }
}
