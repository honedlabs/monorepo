<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set meta properties on a class
 */
trait HasMeta
{
    /** Meta are non-uniform properties for the class */
    protected array|Closure $meta = [];

    /**
     * Set the meta, chainable.
     */
    public function meta(array|Closure $meta): static
    {
        $this->setMeta($meta);

        return $this;
    }

    /**
     * Set the meta quietly.
     */
    public function setMeta(array|Closure|null $meta): void
    {
        if (is_null($meta)) {
            return;
        }
        $this->meta = $meta;
    }

    /**
     * Get the meta.
     */
    public function getMeta(): array
    {
        return $this->evaluate($this->meta);
    }

    /**
     * Check if the class has meta.
     */
    public function hasMeta(): bool
    {
        return is_array($this->getMeta()) && ! empty($this->getMeta());
    }

    /**
     * Check if the class does not have meta.
     */
    public function lacksMeta(): bool
    {
        return ! $this->hasMeta();
    }
}
