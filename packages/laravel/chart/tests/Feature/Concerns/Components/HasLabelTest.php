<?php

declare(strict_types=1);

use Honed\Chart\Emphasis;
use Honed\Chart\Label;

beforeEach(function () {
    $this->emphasis = Emphasis::make();
});

it('can have label', function () {
    expect($this->emphasis)
        ->getLabel()->toBeNull()
        ->label(false)->toBe($this->emphasis)
        ->getLabel()->toBeNull()
        ->label(fn (Label $label) => $label)->toBe($this->emphasis)
        ->getLabel()->toBeInstanceOf(Label::class)
        ->label(null)->toBe($this->emphasis)
        ->getLabel()->toBeNull()
        ->label(Label::make())->toBe($this->emphasis)
        ->getLabel()->toBeInstanceOf(Label::class);
});
