<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Support\Stringable;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasLabel
{
    /**
     * @var string|(\Closure(mixed...):string)|null
     */
    protected $label = null;

    /**
     * Set the label, chainable.
     *
     * @param  string|(\Closure(mixed...):string)  $label
     * @return $this
     */
    public function label(string|\Closure $label): static
    {
        $this->setLabel($label);

        return $this;
    }

    /**
     * Set the label quietly.
     *
     * @param  string|(\Closure(mixed...):string)|null  $label
     */
    public function setLabel(string|\Closure|null $label): void
    {
        if (\is_null($label)) {
            return;
        }

        $this->label = $label;
    }

    /**
     * Get the label using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function getLabel(array $named = [], array $typed = []): ?string
    {
        return $this->evaluate($this->label, $named, $typed);
    }

    /**
     * Resolve the label using the given closure dependencies.
     *
     * @param  array<string, mixed>  $named
     * @param  array<string, mixed>  $typed
     */
    public function resolveLabel(array $named = [], array $typed = []): ?string
    {
        $label = $this->getLabel($named, $typed);
        $this->setLabel($label);

        return $label;
    }

    /**
     * Determine if the class has a label.
     */
    public function hasLabel(): bool
    {
        return ! \is_null($this->label);
    }

    /**
     * Convert a string to the label format.
     *
     * @param  string|\Closure():string  $name
     */
    public function makeLabel(string|\Closure $name): string
    {
        return (new Stringable($this->evaluate($name)))
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->value();
    }
}
