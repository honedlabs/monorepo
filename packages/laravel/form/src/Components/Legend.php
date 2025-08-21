<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Core\Concerns\HasLabel;
use Honed\Form\Abstracts\Component;

class Legend extends Component
{
    use HasLabel;

    /**
     * Create a new legend instance.
     */
    public static function make(string $value): static
    {
        return resolve(static::class)->label($value);
    }

    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.legend', 'Legend.vue');
    }

    /**
     * Get the array representation of the legend.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'label' => $this->getLabel(),
            ...parent::representation(),
        ];
    }
}
