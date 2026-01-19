<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Components\Component;
use Honed\Form\Components\Field;
use Honed\Form\Components\Grouping;
use Honed\Form\Form;
use Illuminate\Contracts\Support\Arrayable;

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
     * Set the initial values of the component.
     * 
     * @param array<string, mixed>|Arrayable<string, mixed> $data
     * @return $this
     */
    public function withInitialValues(array|Arrayable $data): static
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        foreach ($data as $key => $value) {
            $this->getField($key)?->defaultValue($value);
        }

        return $this;
    }

    /**
     * Find and return a field component by the given key.
     */
    public function getField(string $key): ?Field
    {
        foreach ($this->getSchema() as $component) {
            if ($this->equals($key, $component)) {
                return $component;
            } else if ($component instanceof Grouping) {
                if ($child = $component->getField($key)) {
                    return $child;
                }
            }
        }

        return null;
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

    /**
     * Determine if the component is equal to the given key.
     */
    protected function equals(string $key, string|Field $component): bool
    {
        return is_string($component) 
            ? $component === $key 
            : $component->getName() === $key;
    }
}
