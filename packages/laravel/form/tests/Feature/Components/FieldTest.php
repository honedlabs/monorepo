<?php

declare(strict_types=1);

use Honed\Form\Components\Input;
use Honed\Form\Enums\FormComponent;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'name',
            'defaultValue' => '',
            'label' => 'Name',
            'component' => FormComponent::Input->value,
        ]);
});
