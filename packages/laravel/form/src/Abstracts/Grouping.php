<?php

declare(strict_types=1);

namespace Honed\Form\Abstracts;

use Honed\Form\Concerns\HasSchema;

abstract class Grouping extends Component
{
    use HasSchema;

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