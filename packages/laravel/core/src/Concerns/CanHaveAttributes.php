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
     * @param  array<string, mixed>  $attributes
     * @return $this
     */
    public function attributes(array $attributes): static
    {
        $this->attributes = [...$this->attributes, ...$attributes];

        return $this;
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
