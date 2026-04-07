<?php

declare(strict_types=1);

use Honed\Chart\AxisPointer;
use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->pointer = AxisPointer::make();
});

it('can have cross style', function () {
    expect($this->pointer)
        ->getCrossStyle()->toBeNull()
        ->crossStyle()->toBe($this->pointer)
        ->getCrossStyle()->toBeInstanceOf(LineStyle::class)
        ->crossStyle(false)->toBe($this->pointer)
        ->getCrossStyle()->toBeNull()
        ->crossStyle(fn (LineStyle $s) => $s)->toBe($this->pointer)
        ->getCrossStyle()->toBeInstanceOf(LineStyle::class)
        ->crossStyle(null)->toBe($this->pointer)
        ->getCrossStyle()->toBeNull()
        ->crossStyle(LineStyle::make())->toBe($this->pointer)
        ->getCrossStyle()->toBeInstanceOf(LineStyle::class);
});
