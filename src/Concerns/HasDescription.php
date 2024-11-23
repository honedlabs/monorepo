<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin Honed\Core\Concerns\Evaluable
 */
trait HasDescription
{
    /**
     * @var string|\Closure(mixed...):string|null
     */
    protected $description = null;

    /**
     * Set the description, chainable.
     *
     * @param  string|\Closure(mixed...):string  $description
     * @return $this
     */
    public function description(string|\Closure $description): static
    {
        $this->setDescription($description);

        return $this;
    }

    /**
     * Set the description quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $description
     */
    public function setDescription(string|\Closure|null $description): void
    {
        if (is_null($description)) {
            return;
        }

        $this->description = $description;
    }

    /**
     * Get the description using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getDescription(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->description, $named, $typed);
    }

    /**
     * Resolve the description using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveDescription(array $named = [], array $typed = []): ?string
    {
        $this->setDescription($this->getDescription($named, $typed));

        return $this->description;
    }

    /**
     * Determine if the class does not have a description.
     */
    public function missingDescription(): bool
    {
        return \is_null($this->description);
    }

    /**
     * Determine if the class has a description.
     */
    public function hasDescription(): bool
    {
        return ! $this->missingDescription();
    }
}
