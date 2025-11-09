<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Concerns\HasText;
use Honed\Form\Enums\FormComponent;

class Text extends Component
{
    use HasText;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'text';

    /**
     * Create a new text instance.
     */
    public static function make(?string $value = null): static
    {
        return app(static::class)->text($value);
    }

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Text;
    }

    /**
     * Get the array representation of the text.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            ...parent::representation(),
            'text' => $this->getText(),
        ];
    }
}
