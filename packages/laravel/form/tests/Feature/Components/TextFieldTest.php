<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Input;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has empty value', function () {
    expect($this->component)
        ->empty()->toBe('')
        ->getDefaultValue()->toBe('');
});

it('has placeholder', function () {
    expect($this->component)
        ->getPlaceholder()->toBeNull()
        ->placeholder('Enter your name')->toBe($this->component)
        ->getPlaceholder()->toBe('Enter your name');
});

it('has array representation', function () {
    expect($this->component)
        ->placeholder('Enter your name')->toBe($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'name',
            'label' => 'Name',
            'value' => $this->component->empty(),
            'placeholder' => 'Enter your name',
            'component' => FormComponent::Input->value,
        ]);
});
