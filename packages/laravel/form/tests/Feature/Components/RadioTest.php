<?php

declare(strict_types=1);

use Honed\Form\Components\Radio;
use Honed\Form\Enums\FormComponent;
use Honed\Option\Option;

beforeEach(function () {
    $this->component = Radio::make('type');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Radio)
        ->getComponent()->toBe(FormComponent::Radio->value);
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
        ->options([Option::make('type', 'Type')])->toBe($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'type',
            'label' => 'Type',
            'component' => FormComponent::Radio->value,
            'options' => [
                [
                    'value' => 'type',
                    'label' => 'Type',
                ],
            ],
        ]);
});