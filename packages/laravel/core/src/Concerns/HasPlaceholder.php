<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasPlaceholder
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $placeholder = null;

    /**
     * Set the placeholder, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $placeholder
     * @return $this
     */
    public function placeholder(string|\Closure $placeholder): static
    {
        $this->setPlaceholder($placeholder);

        return $this;
    }

    /**
     * Set the placeholder quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $placeholder
     */
    public function setPlaceholder(string|\Closure|null $placeholder): void
    {
        if (is_null($placeholder)) {
            return;
        }
        $this->placeholder = $placeholder;
    }

    /**
     * Get the placeholder using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getPlaceholder(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->placeholder, $named, $typed);
    }

    /**
     * Resolve the placeholder using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolvePlaceholder(array $named = [], array $typed = []): ?string
    {
        $this->setPlaceholder($this->getPlaceholder($named, $typed));

        return $this->placeholder;
    }

    /**
     * Determine if the class does not have a placeholder.
     */
    public function missingPlaceholder(): bool
    {
        return \is_null($this->placeholder);
    }

    /**
     * Determine if the class has a placeholder.
     */
    public function hasPlaceholder(): bool
    {
        return ! $this->missingPlaceholder();
    }
}
