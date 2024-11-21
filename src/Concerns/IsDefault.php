<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait IsDefault
{
    /**
     * @var bool|(\Closure():bool)
     */
    protected $default = false;

    /**
     * Set the class as default, chainable
     * 
     * @param bool|(\Closure():bool) $default
     * @return $this
     */
    public function default(bool|\Closure $default = true): static
    {
        $this->setDefault($default);

        return $this;
    }

    /**
     * Set the default quietly
     * 
     * @param bool|(\Closure():bool)|null $default
     */
    public function setDefault(bool|\Closure|null $default): void
    {
        if (is_null($default)) {
            return;
        }
        $this->default = $default;
    }

    /**
     * Determine if the class is default.
     */
    public function isDefault(): bool
    {
        return (bool) $this->evaluate($this->default);
    }

    /**
     * Determine if the class is not default.
     */
    public function isNotDefault(): bool
    {
        return ! $this->isDefault();
    }
}
