<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasType
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $type = null;

    /**
     * Set the type property, chainable
     *
     * @param  string|\Closure(mixed...)  $type
     * @return $this
     */
    public function type(string|\Closure $type): static
    {
        $this->setType($type);

        return $this;
    }

    /**
     * Set the type property quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $type
     */
    public function setType(string|\Closure|null $type): void
    {
        if (is_null($type)) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Get the type using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getType(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->type, $named, $typed);
    }

    /**
     * Resolve the type using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveType(array $named = [], array $typed = []): ?string
    {
        $this->setType($this->getType($named, $typed));

        return $this->type;
    }

    /**
     * Determine if the class does not have a type.
     */
    public function missingType(): bool
    {
        return \is_null($this->type);
    }

    /**
     * Determine if the class has a type.
     */
    public function hasType(): bool
    {
        return ! $this->missingType();
    }
}
