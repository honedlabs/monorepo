<?php

declare(strict_types=1);

use Honed\Form\Components\Input;

beforeEach(function () {
    $this->component = Input::make('name');
});

it('can be autofocused', function () {
    expect($this->component)
        ->isAutofocused()->toBeFalse()
        ->isNotAutofocused()->toBeTrue()
        ->autofocus()->toBe($this->component)
        ->isAutofocused()->toBeTrue()
        ->isNotAutofocused()->toBeFalse()
        ->dontAutofocus()->toBe($this->component)
        ->isAutofocused()->toBeFalse()
        ->isNotAutofocused()->toBeTrue();
});
