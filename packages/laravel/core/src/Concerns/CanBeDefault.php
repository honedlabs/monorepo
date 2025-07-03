<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanBeDefault
{
    /**
     * Whether the instance is the default.
     *
     * @var bool
     */
    protected $default = false;

    /**
     * Set the instance to the default.
     *
     * @return $this
     */
    public function default(bool $value = true): static
    {
        $this->default = $value;

        return $this;
    }

    /**
     * Set the instance to not the default.
     *
     * @return $this
     */
    public function notDefault(bool $value = true): static
    {
        return $this->default(! $value);
    }

    /**
     * Determine if the instance is the default.
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * Determine if the instance is not the default.
     */
    public function isNotDefault(): bool
    {
        return ! $this->isDefault();
    }
}
