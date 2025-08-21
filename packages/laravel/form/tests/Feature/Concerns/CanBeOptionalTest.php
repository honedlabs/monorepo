<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be optional', function () {
    expect($this->component)
        ->isOptional()->toBeFalse()
        ->optional()->toBe($this->component)
        ->isOptional()->toBeTrue()
        ->notOptional()->toBe($this->component)
        ->isNotOptional()->toBeTrue();
});