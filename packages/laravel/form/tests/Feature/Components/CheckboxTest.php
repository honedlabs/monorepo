<?php

declare(strict_types=1);

use Honed\Form\Components\Checkbox;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Checkbox::make('remember');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Checkbox)
        ->getComponent()->toBe(FormComponent::Checkbox->value);
});

it('has boolean empty', function () {
    expect($this->component)
        ->empty()->toBeFalse();
});
