<?php

use Honed\Core\Concerns\IsActive;

beforeEach(function () {
    $this->test = new class()
    {
        use IsActive;
    };
});

it('sets', function () {
    expect($this->test)
        ->isActive()->toBeFalse()
        ->active()->toBe($this->test)
        ->isActive()->toBeTrue();
});
