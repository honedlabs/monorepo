<?php

declare(strict_types=1);

use Honed\Chart\ShadowStyle;

beforeEach(function () {
    $this->shadowStyle = ShadowStyle::make();
});

it('has empty array representation by default', function () {
    expect($this->shadowStyle->toArray())->toEqual([]);
});

it('serializes shadow style options', function () {
    $this->shadowStyle
        ->color('rgba(10,20,30,0.3)')
        ->shadowBlur(10)
        ->shadowOffsetX(3)
        ->shadowOffsetY(4)
        ->opacity(25);

    expect($this->shadowStyle->toArray())->toEqual([
        'color' => 'rgba(10,20,30,0.3)',
        'shadowBlur' => 10,
        'shadowOffsetX' => 3,
        'shadowOffsetY' => 4,
        'opacity' => 25,
    ]);
});
