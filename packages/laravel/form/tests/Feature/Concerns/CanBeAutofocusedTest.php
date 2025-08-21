<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be autofocused', function () {
    expect($this->component)
        ->isAutofocused()->toBeFalse()
        ->autofocus()->toBe($this->component)
        ->isAutofocused()->toBeTrue()
        ->notAutofocused()->toBe($this->component)
        ->isNotAutofocused()->toBeTrue();
});