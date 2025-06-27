<?php

declare(strict_types=1);

use Honed\Core\Concerns\CanBeActive;

beforeEach(function () {
    $this->test = new class()
    {
        use CanBeActive;
    };
});

it('sets', function () {
    expect($this->test)
        ->isNotActive()->toBeTrue()
        ->isActive()->toBeFalse()
        ->active()->toBe($this->test)
        ->isActive()->toBeTrue()
        ->notActive()->toBe($this->test)
        ->isNotActive()->toBeTrue();
});
