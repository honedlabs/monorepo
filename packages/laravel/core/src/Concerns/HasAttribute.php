<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasAttribute
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $attribute = null;

    /**
     * Set the attribute to be used, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $attribute
     * @return $this
     */
    public function attribute(string|\Closure $attribute): static
    {
        $this->setAttribute($attribute);

        return $this;
    }

    /**
     * Set the attribute to be used quietly.
     *
     * @param  string|(\Closure(mixed...):string)  $attribute
     */
    public function setAttribute(string|\Closure|null $attribute): void
    {
        if (is_null($attribute)) {
            return;
        }
        $this->attribute = $attribute;
    }

    /**
     * Get the attribute using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getAttribute(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->attribute, $named, $typed);
    }

    /**
     * Resolve the attribute using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveAttribute(array $named = [], array $typed = []): ?string
    {
        $this->setAttribute($this->getAttribute($named, $typed));

        return $this->attribute;
    }

    /**
     * Determine if the class does not have a attribute.
     */
    public function missingAttribute(): bool
    {
        return \is_null($this->attribute);
    }

    /**
     * Determine if the class has a attribute.
     */
    public function hasAttribute(): bool
    {
        return ! $this->missingAttribute();
    }
}
