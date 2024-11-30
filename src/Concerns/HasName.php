<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasName
{
    /**
     * @var string|\Closure(mixed...):string|null
     */
    protected $name = null;

    /**
     * Set the name, chainable.
     *
     * @param  string|(\Closure(mixed...):string) $name
     * @return $this
     */
    public function name(string|\Closure $name): static
    {
        $this->setName($name);

        return $this;
    }

    /**
     * Set the name quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $name
     */
    public function setName(string|\Closure|null $name): void
    {
        if (is_null($name)) {
            return;
        }
        $this->name = $name;
    }

    /**
     * Get the name using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getName(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->name, $named, $typed);
    }

    /**
     * Resolve the name using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveName(array $named = [], array $typed = []): ?string
    {
        $this->setName($this->getName($named, $typed));

        return $this->name;
    }

    /**
     * Determine if the class does not have a name.
     *
     * @return bool
     */
    public function missingName(): bool
    {
        return \is_null($this->name);
    }

    /**
     * Determine if the class has a name.
     *
     * @return bool
     */
    public function hasName(): bool
    {
        return ! $this->missingName();
    }

    /**
     * Convert a string to the name format
     *
     * @param  string|\Stringable|(\Closure():string|\Stringable)  $label
     */
    public function makeName(string|\Stringable|\Closure $label): string
    {
        return str($this->evaluate($label))->snake()->lower()->toString();
    }
}
