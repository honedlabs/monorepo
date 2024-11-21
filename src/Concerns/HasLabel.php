<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasLabel
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $label = null;

    /**
     * Set the label, chainable.
     *
     * @param  string|\Closure():string  $label
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
     * @param  string|(\Closure():string)|null  $label
     */
    public function setLabel(string|\Closure|null $label): void
    {
        if (is_null($label)) {
            return;
        }
        $this->label = $label;
    }

    /**
     * Get the label.
     */
    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    /**
     * Determine if the class does not have a label.
     */
    public function missingLabel(): bool
    {
        return \is_null($this->label);
    }

    /**
     * Determine if the class has a label.
     */
    public function hasLabel(): bool
    {
        return ! $this->missingLabel();
    }

    /**
     * Convert a string to the label format.
     */
    public function makeLabel(mixed $name): string
    {
        return str((string) $this->evaluate($name))->headline()->lower()->ucfirst()->toString();
    }
}
