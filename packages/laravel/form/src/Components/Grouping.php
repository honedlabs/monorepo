<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Concerns\HasSchema;

abstract class Grouping extends Component
{
    use HasSchema;

    /**
     * Create a new grouping instance.
     *
     * @param  list<Component>  $schema
     */
    public static function make(array $schema = []): static
    {
        return app(static::class)->schema($schema);
    }

    /**
     * Get the array representation of the form grouping.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'schema' => $this->resolveSchema($this->getForm()),
        ];
    }
}
