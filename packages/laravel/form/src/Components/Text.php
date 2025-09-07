<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use Honed\Form\Abstracts\Component;
use Honed\Form\Concerns\HasText;

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
        return resolve(static::class)->text($value);
    }

    /**
     * The name of the component.
     */
    public function component(): string
    {
        /** @var string */
        return config('form.components.text', 'Text.vue');
    }

    /**
     * Get the array representation of the text.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'text' => $this->getText(),
            ...parent::representation(),
        ];
    }
}
