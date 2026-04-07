<?php

declare(strict_types=1);

use Honed\Chart\AxisPointer;
use Honed\Chart\AxisPointerLabel;

beforeEach(function () {
    $this->pointer = AxisPointer::make();
});

it('can have axis pointer label', function () {
    expect($this->pointer)
        ->getAxisPointerLabel()->toBeNull()
        ->label()->toBe($this->pointer)
        ->getAxisPointerLabel()->toBeInstanceOf(AxisPointerLabel::class)
        ->label(false)->toBe($this->pointer)
        ->getAxisPointerLabel()->toBeNull()
        ->label(fn (AxisPointerLabel $l) => $l)->toBe($this->pointer)
        ->getAxisPointerLabel()->toBeInstanceOf(AxisPointerLabel::class)
        ->label(null)->toBe($this->pointer)
        ->getAxisPointerLabel()->toBeNull()
        ->label(AxisPointerLabel::make())->toBe($this->pointer)
        ->getAxisPointerLabel()->toBeInstanceOf(AxisPointerLabel::class);
});
