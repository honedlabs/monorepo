<?php

declare(strict_types=1);

use Honed\Form\Components\Select;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Select::make('type');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Select)
        ->getComponent()->toBe(FormComponent::Select->value);
});
