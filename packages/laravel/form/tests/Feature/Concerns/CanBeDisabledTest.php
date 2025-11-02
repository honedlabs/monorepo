<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be disabled', function () {
    expect($this->component)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue()
        ->disabled()->toBe($this->component)
        ->isDisabled()->toBeTrue()
        ->isNotDisabled()->toBeFalse()
        ->dontDisable()->toBe($this->component)
        ->isDisabled()->toBeFalse()
        ->isNotDisabled()->toBeTrue();
});
