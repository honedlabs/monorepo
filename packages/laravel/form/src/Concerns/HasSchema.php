<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Components\Component;
use Honed\Form\Form;

trait HasSchema
{
    /**
     * The schema of the component.
     *
     * @var list<Component>
     */
    protected $schema = [];

    /**
     * Set the schema of the component.
     *
     * @param  list<Component>  $schema
     * @return $this
     */
    public function schema(array $schema = []): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Prepend a component to the schema.
     *
     * @return $this
     */
    public function append(Component $component): static
    {
        $this->schema[] = $component;

        return $this;
    }

    /**
     * Prepend a component to the schema.
     *
     * @return $this
     */
    public function prepend(Component $component): static
    {
        array_unshift($this->schema, $component);

        return $this;
    }

    /**
     * Get the schema of the component.
     *
     * @return list<Component>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * Resolve the schema of the component.
     *
     * @return list<array<string, mixed>>
     */
    public function resolveSchema(?Form $form = null): array
    {
        return array_map(
            static fn (Component $component) => $component->form($form)->toArray(),
            array_values(
                array_filter($this->getSchema(), fn (Component $component) => $component->isAllowed())
            )
        );
    }
}
