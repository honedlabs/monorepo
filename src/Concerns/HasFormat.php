<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Attributes\Format;
use ReflectionClass;

/**
 * Set a format for a class.
 */
trait HasFormat
{
    protected string|Closure|null $format = null;

    /**
     * Set the format, chainable.
     */
    public function format(string|Closure $format): static
    {
        $this->setFormat($format);

        return $this;
    }

    /**
     * Set the format quietly.
     */
    public function setFormat(string|Closure|null $format): void
    {
        if (is_null($format)) {
            return;
        }
        $this->format = $format;
    }

    /**
     * Get the format
     */
    public function getFormat(): ?string
    {
        return $this->evaluate($this->format) ?? $this->evaluateFormatAttribute();
    }

    /**
     * Check if the class has a format
     */
    public function hasFormat(): bool
    {
        return ! is_null($this->format);
    }

    public function lacksFormat(): bool
    {
        return ! $this->hasFormat();
    }

    /**
     * Evaluate the format attribute if present
     */
    protected function evaluateFormatAttribute(): ?string
    {
        $attributes = (new ReflectionClass($this))->getAttributes(Format::class);

        if (! empty($attributes)) {
            return $attributes[0]->newInstance()->getFormat();
        }

        return null;
    }
}
