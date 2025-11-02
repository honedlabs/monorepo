<?php

declare(strict_types=1);

use Honed\Form\Components\Text;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->text = 'Enter the details of the user.';

    $this->component = Text::make($this->text);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Text)
        ->getComponent()->toBe(FormComponent::Text->value);
});

it('has array representation', function () {
    expect($this->component->toArray())
        ->toEqualCanonicalizing([
            'text' => $this->text,
            'component' => FormComponent::Text->value,
        ]);
});
