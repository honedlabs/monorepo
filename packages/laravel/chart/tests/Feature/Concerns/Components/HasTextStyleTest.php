<?php

declare(strict_types=1);

use Honed\Chart\Chart;
use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->chart = Chart::make();
});

it('can have text style', function () {
    expect($this->chart)
        ->getTextStyle()->toBeNull()
        ->textStyle()->toBe($this->chart)
        ->getTextStyle()->toBeInstanceOf(TextStyle::class)
        ->textStyle(false)->toBe($this->chart)
        ->getTextStyle()->toBeNull()
        ->textStyle(fn ($textStyle) => $textStyle)->toBe($this->chart)
        ->getTextStyle()->toBeInstanceOf(TextStyle::class)
        ->textStyle(null)->toBe($this->chart)
        ->getTextStyle()->toBeNull()
        ->textStyle(TextStyle::make())->toBe($this->chart)
        ->getTextStyle()->toBeInstanceOf(TextStyle::class);
});
