<?php

use Honed\Core\Concerns\HasName;

beforeEach(function () {
    $this->test = new class()
    {
        use HasName;
    };
});

it('sets', function () {
    expect($this->test)
        ->getName()->toBeNull()
        ->hasName()->toBeFalse()
        ->name('name')->toBe($this->test)
        ->getName()->toBe('name')
        ->hasName()->toBeTrue();
});
