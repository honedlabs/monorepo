<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has font size', function () {
    expect($this->textStyle)
        ->getFontSize()->toBeNull()
        ->fontSize(14)->toBe($this->textStyle)
        ->getFontSize()->toBe(14);
});
