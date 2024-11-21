<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasPlaceholder
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $placeholder = null;

    /**
     * Set the placeholder, chainable.
     * 
     * @param string|\Closure():string $placeholder
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
     * @param string|(\Closure():string)|null $placeholder
     */
    public function setPlaceholder(string|\Closure|null $placeholder): void
    {
        if (is_null($placeholder)) {
            return;
        }
        $this->placeholder = $placeholder;
    }

    /**
     * Get the placeholder.
     */
    public function getPlaceholder(): ?string
    {
        return $this->evaluate($this->placeholder);
    }

    /**
     * Determine if the class does not have a placeholder.
     */
    public function missingPlaceholder(): bool
    {
        return is_null($this->placeholder);
    }

    /**
     * Determine if the class has a placeholder.
     */
    public function hasPlaceholder(): bool
    {
        return ! $this->missingPlaceholder();
    }
}
