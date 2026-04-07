<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has shadow offset', function () {
    expect($this->textStyle)
        ->getShadowOffsetX()->toBeNull()
        ->getShadowOffsetY()->toBeNull()
        ->shadowOffsetX(2)->toBe($this->textStyle)
        ->getShadowOffsetX()->toBe(2)
        ->shadowOffsetY(-1)->toBe($this->textStyle)
        ->getShadowOffsetY()->toBe(-1)
        ->shadowOffset(5, 6)->toBe($this->textStyle)
        ->getShadowOffsetX()->toBe(5)
        ->getShadowOffsetY()->toBe(6);
});
