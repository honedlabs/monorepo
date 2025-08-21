<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Abstracts\Component;

trait HasSchema
{
    /**
     * The schema of the component.
     *
     * @var array<int, \Honed\Form\Abstracts\Component>
     */
    protected $schema = [];

    /**
     * Set the schema of the component.
     *
     * @param  array<int, \Honed\Form\Abstracts\Component>  $schema
     * @return $this
     */
    public function schema(array $schema = []): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get the schema of the component.
     *
     * @return array<int, \Honed\Form\Abstracts\Component>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * Get the array representation of the schema.
     *
     * @return array<int, array<string, mixed>>
     */
    public function schemaToArray(): array
    {
        return array_map(
            static fn (Component $component) => $component->toArray(),
            $this->schema
        );
    }
}
