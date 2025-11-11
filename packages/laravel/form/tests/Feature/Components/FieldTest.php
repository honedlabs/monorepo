<?php

declare(strict_types=1);

use Honed\Form\Components\DatePicker;
use Honed\Form\Enums\FormComponent;
use Honed\Form\Form;

beforeEach(function () {
    $this->component = DatePicker::make('start_at'); // use date field to test as it does not modify the 'empty()' method
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'start_at',
            'label' => 'Start at',
            'component' => FormComponent::Date->value,
        ]);
});

it('has default value', function () {
    expect($this->component)
        ->getDefaultValue()->toBeNull()
        ->empty()->toBeNull()
        ->defaultValue('value')->toBe($this->component)
        ->getDefaultValue()->toBe('value')
        ->empty()->toBeNull()
        ->defaultValue(null)->toBe($this->component)
        ->getDefaultValue()->toBeNull()
        ->empty()->toBeNull();
});

it('gets value', function () {
    expect($this->component)
        ->getValue()->toBe($this->component->getDefaultValue())
        ->form(Form::make()->record(['start_at' => '2025-01-01']))
        ->getValue()->toBe('2025-01-01')
        ->using('start_at')->toBe($this->component)
        ->getValue()->toBe('2025-01-01')
        ->using(fn ($record) => $record['start_at'])->toBe($this->component)
        ->getValue()->toBe('2025-01-01');
});

it('has min attribute', function () {
    expect($this->component)
        ->getAttributes()->toBe([])
        ->min(1)->toBe($this->component)
        ->getAttributes()->toBe(['min' => 1]);
});

it('has max attribute', function () {
    expect($this->component)
        ->getAttributes()->toBe([])
        ->max(10)->toBe($this->component)
        ->getAttributes()->toBe(['max' => 10]);
});
