<?php

declare(strict_types=1);

use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has empty array representation by default', function () {
    expect($this->lineStyle->toArray())->toEqual([]);
});

it('serializes line style scalars for echarts', function () {
    $this->lineStyle
        ->color('#00ff00')
        ->width(2)
        ->borderType('dotted')
        ->dashOffset(4)
        ->cap('round')
        ->bevel()
        ->opacity(80)
        ->shadowBlur(2)
        ->shadowColor('#000')
        ->shadowOffsetX(0)
        ->shadowOffsetY(2)
        ->inactiveColor('#ccc')
        ->inactiveWidth(1);

    expect($this->lineStyle->toArray())->toEqual([
        'color' => '#00ff00',
        'width' => 2,
        'type' => 'dotted',
        'dashOffset' => 4,
        'cap' => 'round',
        'join' => 'bevel',
        'shadowBlur' => 2,
        'shadowColor' => '#000',
        'shadowOffsetX' => 0,
        'shadowOffsetY' => 2,
        'opacity' => 80,
        'inactiveColor' => '#ccc',
        'inactiveWidth' => 1,
    ]);
});

it('includes miter limit when join is miter', function () {
    $this->lineStyle->miter(8);

    expect($this->lineStyle->toArray())->toEqual([
        'join' => 'miter',
        'miterLimit' => 8,
    ]);
});
