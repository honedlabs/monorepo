<?php

declare(strict_types=1);

use Honed\Form\Components\Legend;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Legend::make('test');
});

it('defines a component', function () {
    expect($this->component)
        ->getComponent()->toBe(FormComponent::Legend->value)
        ->as('test')->toBe($this->component)
        ->getComponent()->toBe('test');
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'label' => 'test',
            'component' => FormComponent::Legend->value,
        ]);
});
