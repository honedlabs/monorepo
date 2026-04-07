<?php

declare(strict_types=1);

use Honed\Chart\ItemStyle;

beforeEach(function () {
    $this->itemStyle = ItemStyle::make();
});

it('has empty array representation by default', function () {
    expect($this->itemStyle->toArray())->toEqual([]);
});

it('serializes item style options', function () {
    $this->itemStyle
        ->color('#123456')
        ->borderColor('#fedcba')
        ->borderWidth(2)
        ->borderType('dashed')
        ->dashOffset(2)
        ->cap('round')
        ->bevel()
        ->shadowBlur(1)
        ->shadowColor('#888')
        ->shadowOffsetX(0)
        ->shadowOffsetY(1)
        ->opacity(90)
        ->borderRadius(6);

    expect($this->itemStyle->toArray())->toEqual([
        'color' => '#123456',
        'borderColor' => '#fedcba',
        'borderWidth' => 2,
        'borderType' => 'dashed',
        'borderDashOffset' => 2,
        'borderCap' => 'round',
        'borderJoin' => 'bevel',
        'shadowBlur' => 1,
        'shadowColor' => '#888',
        'shadowOffsetX' => 0,
        'shadowOffsetY' => 1,
        'opacity' => 90,
        'borderRadius' => 6,
    ]);
});

it('includes border miter limit when join is miter', function () {
    $this->itemStyle->miter(10);

    expect($this->itemStyle->toArray())->toEqual([
        'borderJoin' => 'miter',
        'borderMiterLimit' => 10,
    ]);
});
