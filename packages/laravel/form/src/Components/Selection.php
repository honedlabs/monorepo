<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Core\Concerns\HasPlaceholder;
use Honed\Option\Concerns\CanBeMultiple;
use Honed\Option\Concerns\HasOptions;

abstract class Selection extends Field
{
    use CanBeMultiple;
    use HasOptions;
    use HasPlaceholder;

    /**
     * Get the array representation of the selection.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'placeholder' => $this->getPlaceholder() ?: null,
            'multiple' => $this->isMultiple() ?: null,
            'options' => $this->getOptionsArray() ?: null,
        ];
    }
}
