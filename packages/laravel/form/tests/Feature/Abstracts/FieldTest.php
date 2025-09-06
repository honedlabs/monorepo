<?php

declare(strict_types=1);

use Honed\Form\Components\Input;
use Honed\Form\Components\Legend;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has array representation', function () {
    expect($this->component)
        ->toArray()->toEqualCanonicalizing([
            'name' => 'name',
            'label' => 'Name',
            'component' => 'Input.vue'
        ]);
});
