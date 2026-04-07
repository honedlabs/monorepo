<?php

declare(strict_types=1);

use Honed\Chart\AxisPointerLabel;
use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->pointerLabel = AxisPointerLabel::make();
});

it('has empty array representation by default', function () {
    expect($this->pointerLabel->toArray())->toEqual([]);
});

it('has higher order textStyle proxy', function () {
    expect($this->pointerLabel->textStyle)->toBeInstanceOf(HigherOrderTextStyle::class);
});

it('serializes axis pointer label options', function () {
    $this->pointerLabel
        ->show()
        ->precision(3)
        ->formatter('{c}')
        ->margin(8)
        ->backgroundColor('#222')
        ->borderColor('#444')
        ->borderWidth(1)
        ->textStyle(fn (TextStyle $ts) => $ts->color('#eee')->fontSize(11));

    expect($this->pointerLabel->toArray())->toEqual([
        'show' => true,
        'precision' => 3,
        'formatter' => '{c}',
        'margin' => 8,
        'backgroundColor' => '#222',
        'borderColor' => '#444',
        'borderWidth' => 1,
        'textStyle' => [
            'color' => '#eee',
            'fontSize' => 11,
        ],
    ]);
});
