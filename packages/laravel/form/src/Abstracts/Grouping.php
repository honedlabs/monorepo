<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Form\Concerns\HasSchema;

abstract class Grouping extends Component
{
    use HasSchema;

    /**
     * Create a new grouping instance.
     * 
     * @param array<int, \Honed\Form\Component> $schema
     */
    public static function make(array $schema = []): static
    {
        return resolve(static::class)->schema($schema);
    }

    /**
     * Get the array representation of the form grouping.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'schema' => $this->schemaToArray(),
            ...parent::representation(),
        ];
    }
}