<?php

declare(strict_types=1);

use Honed\Chart\AxisPointer;
use Honed\Chart\ShadowStyle;

beforeEach(function () {
    $this->pointer = AxisPointer::make();
});

it('can have shadow style on axis pointer', function () {
    expect($this->pointer)
        ->getAxisPointerShadowStyle()->toBeNull()
        ->shadowStyle()->toBe($this->pointer)
        ->getAxisPointerShadowStyle()->toBeInstanceOf(ShadowStyle::class)
        ->shadowStyle(false)->toBe($this->pointer)
        ->getAxisPointerShadowStyle()->toBeNull()
        ->shadowStyle(fn (ShadowStyle $s) => $s)->toBe($this->pointer)
        ->getAxisPointerShadowStyle()->toBeInstanceOf(ShadowStyle::class)
        ->shadowStyle(null)->toBe($this->pointer)
        ->getAxisPointerShadowStyle()->toBeNull()
        ->shadowStyle(ShadowStyle::make())->toBe($this->pointer)
        ->getAxisPointerShadowStyle()->toBeInstanceOf(ShadowStyle::class);
});
