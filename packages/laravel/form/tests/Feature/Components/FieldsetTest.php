<?php

declare(strict_types=1);

use Honed\Form\Components\Fieldset;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Fieldset::make([]);
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Fieldset)
        ->getComponent()->toBe(FormComponent::Fieldset->value);
});
