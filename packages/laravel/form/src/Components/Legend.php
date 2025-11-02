<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Core\Concerns\HasLabel;

class Legend extends Component
{
    use HasLabel;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'legend';

    /**
     * Create a new legend instance.
     */
    public static function make(string $label): static
    {
        return resolve(static::class)->label($label);
    }

    /**
     * The name of the component.
     */
    public function component(): string
    {
        return config()->string('honed-form.components.legend', 'Legend.vue');
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
