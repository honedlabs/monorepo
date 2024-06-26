<?php

namespace Vanguard\Core\Concerns;

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
     * 
     * @param array|Closure $metadata
     * @return static
     */
    public function metadata(array|Closure $metadata): static
    {
        $this->setMetadata($metadata);
        return $this;
    }

    /**
     * Set the metadata quietly.
     * 
     * @param array|\Closure $metadata
     * @return void
     */
    protected function setMetadata(array|Closure $metadata): void
    {
        if (is_null($metadata)) return;
        $this->metadata = $metadata;
    }

    /**
     * Get the metadata.
     * 
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->evaluate($this->metadata);
    }

    /**
     * Check if the class has metadata.
     * 
     * @return bool
     */
    public function hasMetadata(): bool
    {
        return is_array($this->getMetadata()) && !empty($this->getMetadata());
    }
}
