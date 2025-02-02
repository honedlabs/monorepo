<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasLabel
{
    /**
     * @var string|\Closure|null
     */
    protected $label;

    /**
     * Set the label for the instance.
     *
     * @return $this
     */
    public function label(string|\Closure|null $label): static
    {
        if (! \is_null($label)) {
            $this->label = $label;
        }

        return $this;
    }

    /**
     * Get the label for the instance.
     */
    public function getLabel(): ?string
    {
        return $this->label instanceof \Closure
            ? $this->resolveLabel()
            : $this->label;
    }

    /**
     * Evaluate the label for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     */
    public function resolveLabel(array $parameters = [], array $typed = []): ?string
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->label, $parameters, $typed);

        $this->label = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a label set.
     */
    public function hasLabel(): bool
    {
        return ! \is_null($this->label);
    }

    /**
     * Convert a string to the label format.
     */
    public function makeLabel(?string $name): ?string
    {
        if (\is_null($name)) {
            return null;
        }

        return str($name)
            ->afterLast('.')
            ->headline()
            ->lower()
            ->ucfirst()
            ->toString();
    }
}
