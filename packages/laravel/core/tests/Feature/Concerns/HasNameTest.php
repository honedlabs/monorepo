<?php

declare(strict_types=1);

use Honed\Core\Concerns\HasName;

beforeEach(function () {
    $this->test = new class()
    {
        use HasName;
    };
});

it('sets', function () {
    expect($this->test)
        ->hasName()->toBeFalse()
        ->missingName()->toBeTrue()
        ->name('name')
        ->hasName()->toBeTrue()
        ->missingName()->toBeFalse()
        ->getName()->toBe('name');
});
