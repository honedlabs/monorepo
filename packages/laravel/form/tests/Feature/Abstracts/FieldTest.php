<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'name',
            'defaultValue' => '',
            'label' => 'Name',
            'component' => 'Input.vue',
        ]);
});
