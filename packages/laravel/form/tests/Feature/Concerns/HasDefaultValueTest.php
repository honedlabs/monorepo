<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('has default value', function () {
    expect($this->component)
        ->getDefaultValue()->toBe('')
        ->empty()->toBe('')
        ->defaultValue('value')->toBe($this->component)
        ->getDefaultValue()->toBe('value');
});