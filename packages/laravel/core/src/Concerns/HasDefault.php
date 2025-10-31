<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDefault
{
    /**
     * The default value to use if one is not provided.
     *
     * @var mixed
     */
    protected $default;

    /**
     * Set a default value to use if one is not provided.
     *
     * @return $this
     */
    public function default(mixed $default): static
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get the default value to use if one is not provided.
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

    /**
     * Check if the instance has a default value.
     */
    public function hasDefault(): bool
    {
        return isset($this->default);
    }
}
