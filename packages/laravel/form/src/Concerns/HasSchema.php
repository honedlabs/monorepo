<?php

declare(strict_types=1);

namespace Honed\Form\Concerns;

use Honed\Form\Abstracts\Component;
use Honed\Form\Form;

trait HasSchema
{
    /**
     * The schema of the component.
     *
     * @var array<int, Component>
     */
    protected $schema = [];

    /**
     * Set the schema of the component.
     *
     * @param  array<int, Component>  $schema
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
     * @return array<int, Component>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }

    /**
     * Resolve the schema of the component.
     *
     * @return array<int, array<string, mixed>>
     */
    public function resolveSchema(?Form $form = null): array
    {
        return array_map(
            static fn (Component $component) => $component->toArray(),
            $this->getSchema()
        );
    }
}
