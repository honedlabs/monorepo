<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has shadow blur', function () {
    expect($this->textStyle)
        ->getShadowBlur()->toBeNull()
        ->shadowBlur(4)->toBe($this->textStyle)
        ->getShadowBlur()->toBe(4);
});
