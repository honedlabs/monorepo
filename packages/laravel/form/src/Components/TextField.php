<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Core\Concerns\HasPlaceholder;

abstract class TextField extends Field
{
    use HasPlaceholder;

    /**
     * Get the placeholder for when the given value is null.
     */
    public function empty(): mixed
    {
        return '';
    }

    /**
     * Get the array representation of the input.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'placeholder' => $this->getPlaceholder() ?: null,
            ...parent::representation(),
        ];
    }
}
