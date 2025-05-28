<?php

declare(strict_types=1);

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
        ->isActive()->toBeTrue()
        ->inactive()->toBe($this->test)
        ->isActive()->toBeFalse();
});
