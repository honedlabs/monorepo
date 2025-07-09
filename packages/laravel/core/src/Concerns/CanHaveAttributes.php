<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanHaveAttributes
{
    /**
     * The attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [];

    /**
     * Set the attributes.
     *
     * @param  string|array<string, mixed>  $attributes
     * @return $this
     */
    public function attributes(string|array $attributes, mixed $value = null): static
    {
        if (is_array($attributes)) {
            $this->attributes = [...$this->attributes, ...$attributes];
        } else {
            $this->attributes[$attributes] = $value;
        }

        return $this;
    }

    /**
     * Set an attribute.
     *
     * @return $this
     */
    public function attribute(string $key, mixed $value): static
    {
        return $this->attributes($key, $value);
    }

    /**
     * Get the attributes.
     *
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
