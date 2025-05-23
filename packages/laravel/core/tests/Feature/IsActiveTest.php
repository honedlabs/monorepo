<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsActive;

beforeEach(function () {
    $this->test = new class {
        use IsActive;
    };
});

it('accesses', function () {
    expect($this->test)
        ->isActive()->toBeFalse()
        ->active()->toBe($this->test)
        ->isActive()->toBeTrue();
});