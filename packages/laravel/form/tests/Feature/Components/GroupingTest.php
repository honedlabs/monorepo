<?php

declare(strict_types=1);

use Honed\Form\Components\FieldGroup;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = FieldGroup::make([]);
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'schema' => [],
            'component' => FormComponent::FieldGroup->value,
        ]);
});
