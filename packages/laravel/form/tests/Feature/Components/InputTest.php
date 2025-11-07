<?php

declare(strict_types=1);

use Honed\Form\Components\Input;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Input)
        ->getComponent()->toBe(FormComponent::Input->value);
});

it('has text type', function () {
    expect($this->component)
        ->text()->toBe($this->component)
        ->getAttributes()->toEqualCanonicalizing([
            'type' => 'text',
        ]);
});

it('has password type', function () {
    expect($this->component)
        ->password()->toBe($this->component)
        ->getAttributes()->toEqualCanonicalizing([
            'type' => 'password',
        ]);
});

it('has file type', function () {
    expect($this->component)
        ->file()->toBe($this->component)
        ->getAttributes()->toEqualCanonicalizing([
            'type' => 'file',
        ]);
});