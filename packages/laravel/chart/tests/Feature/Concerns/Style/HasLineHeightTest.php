<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has line height', function () {
    expect($this->textStyle)
        ->getLineHeight()->toBeNull()
        ->lineHeight(20)->toBe($this->textStyle)
        ->getLineHeight()->toBe(20);
});
