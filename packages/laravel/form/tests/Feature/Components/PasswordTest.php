<?php

declare(strict_types=1);

use Honed\Form\Components\Password;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Password::make('password');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Password)
        ->getComponent()->toBe(FormComponent::Password->value);
});
