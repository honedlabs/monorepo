<?php

declare(strict_types=1);

use Honed\Chart\Enums\FontWeight;
use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has font weight', function () {
    expect($this->textStyle)
        ->getFontWeight()->toBeNull()
        ->bold()->toBe($this->textStyle)
        ->getFontWeight()->toBe(FontWeight::Bold->value)
        ->fontWeight(FontWeight::Normal)->toBe($this->textStyle)
        ->getFontWeight()->toBe(FontWeight::Normal->value);
});
