<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Core\Concerns\HasLabel;
use Honed\Form\Enums\FormComponent;

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
        return app(static::class)->label($label);
    }

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Legend;
    }

    /**
     * Get the array representation of the legend.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'label' => $this->getLabel(),
        ];
    }
}
