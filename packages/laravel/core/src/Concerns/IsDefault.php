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
     * Set the class as default, chainable
     *
     * @return $this
     */
    public function default(bool $default = true): static
    {
        $this->setDefault($default);

        return $this;
    }

    /**
     * Set the default quietly
     */
    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }

    /**
     * Determine if the class is default.
     */
    public function isDefault(): bool
    {
        return $this->default;
    }
}
