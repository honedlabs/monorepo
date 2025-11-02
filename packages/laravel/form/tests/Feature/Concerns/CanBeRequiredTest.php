<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be required', function () {
    expect($this->component)
        ->isRequired()->toBeFalse()
        ->isNotRequired()->toBeTrue()
        ->required()->toBe($this->component)
        ->isRequired()->toBeTrue()
        ->isNotRequired()->toBeFalse()
        ->dontRequire()->toBe($this->component)
        ->isRequired()->toBeFalse()
        ->isNotRequired()->toBeTrue();
});
