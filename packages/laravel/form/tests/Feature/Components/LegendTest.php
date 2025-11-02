<?php

declare(strict_types=1);

use Honed\Form\Components\Legend;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->label = 'Details';

    $this->component = Legend::make($this->label);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Legend)
        ->getComponent()->toBe(FormComponent::Legend->value);
});

it('has array representation', function () {
    expect($this->component->toArray())
        ->toEqualCanonicalizing([
            'label' => $this->label,
            'component' => FormComponent::Legend->value,
        ]);
});
