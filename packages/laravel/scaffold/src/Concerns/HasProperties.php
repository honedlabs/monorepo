<?php

declare(strict_types=1);

namespace Honed\Scaffold\Concerns;

use Illuminate\Support\Collection;
use Honed\Scaffold\Contracts\Property;

trait HasProperties
{
    /**
     * The properties to be added.
     *
     * @var Collection<int, Property>
     */
    protected $properties;

    /**
     * Initialize the properties.
     */
    protected function initializeProperties(): void
    {
        $this->properties = new Collection();
    }

    /**
     * Add a property to the context.
     */
    public function addProperty(Property $property): void
    {
        $this->properties->push($property);
    }

    /**
     * Add multiple properties to the context.
     *
     * @param  list<Property>  $properties
     */
    public function addProperties(array $properties): void
    {
        $this->properties->push(...$properties);
    }

    /**
     * Get the properties for the context.
     *
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }
}