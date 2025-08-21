<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be disabled', function () {
    expect($this->component)
        ->isDisabled()->toBeFalse()
        ->disabled()->toBe($this->component)
        ->isDisabled()->toBeTrue()
        ->notDisabled()->toBe($this->component)
        ->isNotDisabled()->toBeTrue();
});