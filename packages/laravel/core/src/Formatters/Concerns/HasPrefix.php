<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

trait HasPrefix
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $prefix = null;

    /**
     * Set the prefix, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $prefix
     * @return $this
     */
    public function prefix(string|\Closure $prefix): static
    {
        $this->setPrefix($prefix);

        return $this;
    }

    /**
     * Set the prefix quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $prefix
     */
    public function setPrefix(string|\Closure|null $prefix): void
    {
        if (\is_null($prefix)) {
            return;
        }

        $this->prefix = $prefix;
    }

    /**
     * Get the prefix.
     * 
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getPrefix(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->prefix, $named, $typed);
    }

    /**
     * Resolve the prefix using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolvePrefix(array $named = [], array $typed = []): ?string
    {
        $prefix = $this->getPrefix($named, $typed);
        $this->setPrefix($prefix);
        
        return $prefix;
    }

    /**
     * Determine if the class has a prefix.
     */
    public function hasPrefix(): bool
    {
        return ! \is_null($this->prefix);
    }
}
