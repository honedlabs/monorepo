<?php

declare(strict_types=1);

use Honed\Chart\Concerns\HasPadding;

beforeEach(function () {
    $this->class = new class {
        use HasPadding;
    };

    $this->class::flushPaddingState();
});

it('is null by default', function () {
    expect($this->class)
        ->getPadding()->toBeNull();
});

it('can be set', function () {
    expect($this->class)
        ->padding(10)->toBe($this->class)
        ->getPadding()->toBe(10)
        ->pad(100)->toBe($this->class)
        ->getPadding()->toBe(100);
});

it('can be set with a global default', function () {
    $this->class::usePadding(10);

    expect($this->class)
        ->getPadding()->toBe(10);
});

it('has array representation', function () {
    expect($this->class->paddingToArray())
        ->toBeArray()
        ->toHaveKey('padding');
});

