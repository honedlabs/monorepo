<?php

namespace Vanguard\Core\Concerns;

use Closure;

/**
 * Set a label for a class.
 */
trait HasLabel
{
    protected string|Closure|null $label = null;

    /**
     * Set the label, chainable.
     * 
     * @param string|Closure $label
     * @return static
     */
    public function label(string|Closure $label): static
    {
        $this->setLabel($label);
        return $this;
    }

    /**
     * Set the label quietly.
     * 
     * @param string|Closure $label
     * @return void
     */
    protected function setLabel(string|Closure|null $label): void
    {
        if (is_null($label)) return;
        $this->label = $label;
    }

    /**
     * Get the label.
     * 
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    /**
     * Convert a string to the label format.
     * 
     * @param string|Closure $name
     * @return string
     */
    public function toLabel(string|Closure $name): string
    {
        return str($this->evaluate($name))->headline()->lower()->ucfirst();
    }
}
