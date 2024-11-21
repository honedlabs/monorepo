<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasType
{
    /**
     * @var string|(\Closure():string)|null
     */
    protected $type = null;

    /**
     * Set the type property, chainable
     *
     * @param  string|(\Closure():string)  $type
     * @return $this
     */
    public function type(string|\Closure $type): static
    {
        $this->setType($type);

        return $this;
    }

    /**
     * Set the type property quietly.
     *
     * @param  string|(\Closure():string)|null  $type
     */
    public function setType(string|\Closure|null $type): void
    {
        if (is_null($type)) {
            return;
        }
        $this->type = $type;
    }

    /**
     * Get the type
     */
    public function getType(): ?string
    {
        return $this->evaluate($this->type);
    }

    /**
     * Determine if the class does not have a type.
     */
    public function missingType(): bool
    {
        return \is_null($this->type);
    }

    /**
     * Determine if the class has a type.
     */
    public function hasType(): bool
    {
        return ! $this->missingType();
    }
}
