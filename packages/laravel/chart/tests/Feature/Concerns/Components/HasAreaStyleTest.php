<?php

declare(strict_types=1);

use Honed\Chart\AreaStyle;
use Honed\Chart\Series\Line;

beforeEach(function () {
    $this->series = Line::make();
});

it('can have area style', function () {
    expect($this->series)
        ->getAreaStyle()->toBeNull()
        ->areaStyle()->toBe($this->series)
        ->getAreaStyle()->toBeInstanceOf(AreaStyle::class)
        ->areaStyle(false)->toBe($this->series)
        ->getAreaStyle()->toBeNull()
        ->areaStyle(fn ($areaStyle) => $areaStyle)->toBe($this->series)
        ->getAreaStyle()->toBeInstanceOf(AreaStyle::class)
        ->areaStyle(null)->toBe($this->series)
        ->getAreaStyle()->toBeNull()
        ->areaStyle(AreaStyle::make())->toBe($this->series)
        ->getAreaStyle()->toBeInstanceOf(AreaStyle::class);
});
