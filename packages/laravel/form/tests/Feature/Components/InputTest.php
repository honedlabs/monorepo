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
