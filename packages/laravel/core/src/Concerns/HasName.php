<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * @var string|\Closure|null
     */
    protected $name;

    /**
     * Set the name for the instance.
     *
     * @return $this
     */
    public function name(string|\Closure|null $name): static
    {
        if (! \is_null($name)) {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Get the name for the instance.
     */
    public function getName(): ?string
    {
        return $this->name instanceof \Closure
            ? $this->resolveName()
            : $this->name;
    }

    /**
     * Evaluate the name for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function resolveName(array $parameters = [], array $typed = []): ?string
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->name, $parameters, $typed);

        $this->name = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a name set.
     */
    public function hasName(): bool
    {
        return ! \is_null($this->name);
    }

    /**
     * Convert a string to the name format
     */
    public static function makeName(?string $label): ?string
    {
        if (\is_null($label)) {
            return null;
        }

        return str($label)
            ->snake()
            ->lower()
            ->toString();
    }
}
