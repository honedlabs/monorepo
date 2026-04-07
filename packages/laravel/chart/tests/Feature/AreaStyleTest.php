<?php

declare(strict_types=1);

use Honed\Chart\AreaStyle;

beforeEach(function () {
    $this->areaStyle = AreaStyle::make();
});

it('has empty array representation by default', function () {
    expect($this->areaStyle->toArray())->toEqual([]);
});

it('serializes area style options', function () {
    $this->areaStyle
        ->color('#aabbcc')
        ->originStart()
        ->shadowBlur(4)
        ->shadowColor('#000')
        ->shadowOffsetX(1)
        ->shadowOffsetY(2)
        ->opacity(50);

    expect($this->areaStyle->toArray())->toEqual([
        'color' => '#aabbcc',
        'origin' => 'start',
        'shadowBlur' => 4,
        'shadowColor' => '#000',
        'shadowOffsetX' => 1,
        'shadowOffsetY' => 2,
        'opacity' => 50,
    ]);
});
