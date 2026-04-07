<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has shadow color', function () {
    expect($this->textStyle)
        ->getShadowColor()->toBeNull()
        ->shadowColor('#000000')->toBe($this->textStyle)
        ->getShadowColor()->toBe('#000000');
});
