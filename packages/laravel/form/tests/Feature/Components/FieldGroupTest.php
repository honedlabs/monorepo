<?php

declare(strict_types=1);

use Honed\Form\Components\FieldGroup;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = FieldGroup::make([]);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::FieldGroup)
        ->getComponent()->toBe(FormComponent::FieldGroup->value);
});
