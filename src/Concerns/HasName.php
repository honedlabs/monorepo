<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasName
{
    /**
     * @var string|\Closure():string|null
     */
    protected $name = null;

    /**
     * Set the name, chainable.
     *
     * @param  string|\Closure():string  $name
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
     * @param  string|\Closure():string|null  $name
     */
    public function setName(string|\Closure|null $name): void
    {
        if (is_null($name)) {
            return;
        }
        $this->name = $name;
    }

    /**
     * Get the name
     */
    public function getName(): ?string
    {
        return $this->evaluate($this->name);
    }

    /**
     * Determine if the class does not have a name.
     */
    public function missingName(): bool
    {
        return \is_null($this->name);
    }

    /**
     * Determine if the class has a name.
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
