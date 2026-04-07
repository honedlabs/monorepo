<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has font family', function () {
    expect($this->textStyle)
        ->getFontFamily()->toBeNull()
        ->fontFamily('Inter, sans-serif')->toBe($this->textStyle)
        ->getFontFamily()->toBe('Inter, sans-serif');
});
