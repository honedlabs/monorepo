<?php

namespace Conquest\Core\Concerns;

use Closure;

/**
 * Set a format for a class.
 */
trait HasFormat
{
    protected string|Closure $format = null;

    /**
     * Set the format, chainable.
     * 
     * @param string|Closure $format
     * @return static
     */
    public function format(string|Closure $format): static
    {
        $this->setFormat($format);
        return $this;
    }

    /**
     * Set the format quietly.
     * 
     * @param string|Closure $format
     * @return void
     */
    public function setFormat(string|Closure|null $format): void
    {
        if (is_null($format)) return;
        $this->format = $format;
    }

    /**
     * Check if the class has a format
     * 
     * @return bool
     */
    public function hasFormat(): bool
    {
        return !is_null($this->format);
    }

    /**
     * Get the format
     * 
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->evaluate($this->format);
    }
}