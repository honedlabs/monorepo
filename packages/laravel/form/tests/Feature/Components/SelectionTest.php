<?php

declare(strict_types=1);

use Honed\Form\Components\Select;
use Honed\Form\Enums\FormComponent;
use Honed\Option\Option;

beforeEach(function () {
    $this->component = Select::make('type');
});

it('can be multiple', function () {
    expect($this->component)
        ->isMultiple()->toBeFalse()
        ->multiple()->toBe($this->component)
        ->isMultiple()->toBeTrue();
});

it('has options', function () {
    expect($this->component)
        ->options([Option::make('type', 'Type')])->toBe($this->component)
        ->getOptionsArray()->toEqualCanonicalizing([
            [
                'value' => 'type', 'label' => 'Type',
            ],
        ]);
});

it('has array representation', function () {
    expect($this->component)
        ->multiple()->toBe($this->component)
        ->options([Option::make('type', 'Type')])->toBe($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'type',
            'label' => 'Type',
            'component' => FormComponent::Select->value,
            'multiple' => true,
            'options' => [
                [
                    'value' => 'type',
                    'label' => 'Type',
                ],
            ],
        ]);
});
