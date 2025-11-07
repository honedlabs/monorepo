<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Option\Concerns\HasOptions;
use Honed\Option\Concerns\CanBeMultiple;

abstract class Selection extends Field
{
    use CanBeMultiple;
    use HasOptions;

    /**
     * Get the array representation of the selection.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'options' => $this->getOptionsArray(),
            'multiple' => $this->isMultiple() ?: null,
        ];
    }
}