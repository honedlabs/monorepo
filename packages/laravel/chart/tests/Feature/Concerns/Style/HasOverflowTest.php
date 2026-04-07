<?php

declare(strict_types=1);

use Honed\Chart\Enums\Overflow;
use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has overflow', function () {
    expect($this->textStyle)
        ->getOverflow()->toBeNull()
        ->truncate()->toBe($this->textStyle)
        ->getOverflow()->toBe(Overflow::Truncate->value)
        ->overflow(Overflow::Break)->toBe($this->textStyle)
        ->getOverflow()->toBe(Overflow::Break->value);
});
