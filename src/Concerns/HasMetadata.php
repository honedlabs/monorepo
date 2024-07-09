<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set metadata properties on a class
 */
trait HasMetadata
{
    /** Metadata are non-uniform properties for the class */
    protected array|Closure $metadata = [];

    /**
     * Set the metadata, chainable.
     */
    public function metadata(array|Closure $metadata): static
    {
        $this->setMetadata($metadata);

        return $this;
    }

    /**
     * Set the metadata quietly.
     */
    public function setMetadata(array|Closure|null $metadata): void
    {
        if (is_null($metadata)) {
            return;
        }
        $this->metadata = $metadata;
    }

    /**
     * Get the metadata.
     */
    public function getMetadata(): array
    {
        return $this->evaluate($this->metadata);
    }

    /**
     * Check if the class has metadata.
     */
    public function hasMetadata(): bool
    {
        return is_array($this->getMetadata()) && ! empty($this->getMetadata());
    }

    /**
     * Check if the class does not have metadata.
     */
    public function lacksMetadata(): bool
    {
        return ! $this->hasMetadata();
    }
}
