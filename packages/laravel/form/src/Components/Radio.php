<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class Radio extends Field
{
    // use HasOptions;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'radio';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Radio;
    }

    // protected function representation(): array
    // {
    //     return [
    //         'options' => $this->getOptions(),
    //         ...parent::representation(),
    //     ];
    // }
}
