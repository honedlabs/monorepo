<?php

declare(strict_types=1);

namespace Honed\Form\Components;

use BackedEnum;
use Honed\Form\Enums\FormComponent;

class Select extends Field
{
    // use HasOptions;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'select';

    /**
     * The name of the component.
     */
    public function component(): string|BackedEnum
    {
        return FormComponent::Select;
    }

    // protected function representation(): array
    // {
    //     return [
    //         'options' => $this->getOptions(),
    //         ...parent::representation(),
    //     ];
    // }
}
