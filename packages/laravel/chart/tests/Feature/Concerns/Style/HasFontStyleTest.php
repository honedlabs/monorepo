<?php

declare(strict_types=1);

use Honed\Chart\Enums\FontStyle;
use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has font style', function () {
    expect($this->textStyle)
        ->getFontStyle()->toBeNull()
        ->italic()->toBe($this->textStyle)
        ->getFontStyle()->toBe(FontStyle::Italic->value)
        ->fontStyle(FontStyle::Normal)->toBe($this->textStyle)
        ->getFontStyle()->toBe(FontStyle::Normal->value);
});
