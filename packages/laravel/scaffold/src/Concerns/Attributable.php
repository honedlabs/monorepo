<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

trait Attributable
{
    /**
     * The attributes to be added.
     *
     * @var array<class-string, array<array-key, mixed>>
     */
    protected $attributes = [];

    /**
     * Add a new attribute.
     *
     * @param  class-string  $attribute
     * @param  array<array-key, mixed>  $arguments
     * @return $this
     */
    public function attribute(string $attribute, array $arguments = []): static
    {
        $this->attributes[$attribute] = $arguments;

        return $this;
    }

    /**
     * Get the attributes to be added.
     *
     * @return array<class-string, array<array-key, mixed>>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
