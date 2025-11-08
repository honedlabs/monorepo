<?php

declare(strict_types=1);

use Honed\Form\Components\NumberInput;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = NumberInput::make('price');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Number)
        ->getComponent()->toBe(FormComponent::Number->value);
});

it('has zero empty value', function () {
    expect($this->component)
        ->empty()->toBe(0)
        ->getDefaultValue()->toBe(0);
});
