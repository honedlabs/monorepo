<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin Honed\Core\Concerns\Evaluable
 */
trait HasDescription
{
    /**
     * @var string|\Closure():string|null
     */
    protected $description = null;

    /**
     * Set the description, chainable.
     *
     * @param  string|\Closure():string  $description
     * @return $this
     */
    public function description(string|\Closure $description): static
    {
        $this->setDescription($description);

        return $this;
    }

    /**
     * Set the description quietly.
     *
     * @param  string|(\Closure():string)|null  $description
     */
    public function setDescription(string|\Closure|null $description): void
    {
        if (is_null($description)) {
            return;
        }
        $this->description = $description;
    }

    /**
     * Get the description
     */
    public function getDescription(): ?string
    {
        return $this->evaluate($this->description);
    }

    /**
     * Determine if the class does not have a description.
     */
    public function missingDescription(): bool
    {
        return \is_null($this->description);
    }

    /**
     * Determine if the class has a description.
     */
    public function hasDescription(): bool
    {
        return ! $this->missingDescription();
    }
}
