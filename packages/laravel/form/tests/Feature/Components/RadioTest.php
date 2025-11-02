<?php

declare(strict_types=1);

use Honed\Form\Components\Radio;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Radio::make('type');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Radio)
        ->getComponent()->toBe(FormComponent::Radio->value);
});
