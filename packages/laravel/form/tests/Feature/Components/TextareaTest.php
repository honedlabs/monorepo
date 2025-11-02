<?php

declare(strict_types=1);

use Honed\Form\Components\Textarea;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Textarea::make('description');
});

it('has component', function () {
    expect($this->component)
        ->component()->toBe(FormComponent::Textarea)
        ->getComponent()->toBe(FormComponent::Textarea->value);
});
