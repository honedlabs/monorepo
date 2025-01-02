<?php

declare(strict_types=1);

namespace Honed\Core\Formatters\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasSuffix
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $suffix = null;

    /**
     * Set the suffix, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $suffix
     * @return $this
     */
    public function suffix(string|\Closure $suffix): static
    {
        $this->setSuffix($suffix);

        return $this;
    }

    /**
     * Set the suffix quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $suffix
     */
    public function setSuffix(string|\Closure|null $suffix): void
    {
        if (\is_null($suffix)) {
            return;
        }

        $this->suffix = $suffix;
    }

    /**
     * Get the suffix.
     * 
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getSuffix(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->suffix, $named, $typed);
    }

    /**
     * Resolve the suffix using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveSuffix(array $named = [], array $typed = []): ?string
    {
        $suffix = $this->getSuffix($named, $typed);
        $this->setSuffix($suffix);
        
        return $suffix;
    }

    /**
     * Determine if the class has a suffix.
     */
    public function hasSuffix(): bool
    {
        return ! \is_null($this->suffix);
    }
}
