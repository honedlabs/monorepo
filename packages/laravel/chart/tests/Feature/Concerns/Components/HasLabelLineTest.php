<?php

declare(strict_types=1);

use Honed\Chart\Emphasis;
use Honed\Chart\LabelLine;

beforeEach(function () {
    $this->emphasis = Emphasis::make();
});

it('can have label line', function () {
    expect($this->emphasis)
        ->getLabelLine()->toBeNull()
        ->labelLine()->toBe($this->emphasis)
        ->getLabelLine()->toBeInstanceOf(LabelLine::class)
        ->labelLine(false)->toBe($this->emphasis)
        ->getLabelLine()->toBeNull()
        ->labelLine(fn (LabelLine $ll) => $ll)->toBe($this->emphasis)
        ->getLabelLine()->toBeInstanceOf(LabelLine::class)
        ->labelLine(null)->toBe($this->emphasis)
        ->getLabelLine()->toBeNull()
        ->labelLine(LabelLine::make())->toBe($this->emphasis)
        ->getLabelLine()->toBeInstanceOf(LabelLine::class);
});
