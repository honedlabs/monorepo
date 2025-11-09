<?php

declare(strict_types=1);

use Honed\Form\Components\ColorPicker;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = ColorPicker::make('color');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Color)
        ->getComponent()->toBe(FormComponent::Color->value);
});
