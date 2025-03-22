<?php

declare(strict_types=1);

use Honed\Core\Concerns\IsActive;

beforeEach(function () {
    $this->test = new class {
        use IsActive;
    };
});

it('is false by default', function () {
    expect($this->test)
        ->isActive()->toBeFalse();
});

it('sets active', function () {
    expect($this->test)
        ->active()->toBe($this->test)
        ->isActive()->toBeTrue();
});