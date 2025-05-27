<?php

use Honed\Core\Concerns\IsDefault;

beforeEach(function () {
    $this->test = new class {
        use IsDefault;
    };
});

it('sets', function () {
    expect($this->test)
        ->isDefault()->toBeFalse()
        ->default()->toBe($this->test)
        ->isDefault()->toBeTrue();
});