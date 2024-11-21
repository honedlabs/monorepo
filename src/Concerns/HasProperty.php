<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @mixin \Honed\Core\Concerns\Evaluable
 */
trait HasProperty
{
    /**
     * @var string|array<int, string>|(\Closure():string|array<int, string>)|null
     */
    protected $property = null;

    /**
     * Set the property to be used, chainable.
     *
     * @param  string|array<int, string>|(\Closure():string|array<int, string>)  $property
     * @return $this
     */
    public function property(string|array|\Closure $property): static
    {
        $this->setProperty($property);

        return $this;
    }

    /**
     * Set the property to be used quietly.
     * 
     * @param string|array<int, string>|(\Closure():string|array<int, string>)|null $property
     */
    public function setProperty(string|array|\Closure|null $property): void
    {
        if (is_null($property)) {
            return;
        }
        $this->property = $property;
    }

    /**
     * Get the property.
     * 
     * @return string|array<int, string>|null
     */
    public function getProperty(): string|array|null
    {
        return $this->evaluate($this->property);
    }

    /**
     * Determine if the class does not have a property.
     */
    public function missingProperty(): bool
    {
        return \is_null($this->property);
    }

    /**
     * Determine if the class has a property.
     */
    public function hasProperty(): bool
    {
        return ! $this->missingProperty();
    }

    /**
     * Determine if the class has multiple properties.
     */
    public function hasMultipleProperties(): bool
    {
        return is_array($this->getProperty());
    }
}
