<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Honed\Form\Components\Textarea;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Textarea::make('description');
});

it('has empty value', function () {
    expect($this->component)
        ->empty()->toBe('')
        ->getDefaultValue()->toBe('');
});

it('has placeholder', function () {
    expect($this->component)
        ->getPlaceholder()->toBeNull()
        ->placeholder('Enter a description')->toBe($this->component)
        ->getPlaceholder()->toBe('Enter a description');
});

it('has array representation', function () {
    expect($this->component)
        ->placeholder('Enter a description')->toBe($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'description',
            'label' => 'Description',
            'value' => $this->component->empty(),
            'placeholder' => 'Enter a description',
            'component' => FormComponent::Textarea->value,
        ]);
});
