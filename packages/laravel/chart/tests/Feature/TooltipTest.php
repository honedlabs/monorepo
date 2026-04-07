<?php

declare(strict_types=1);

use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->tooltip = Tooltip::make();
});

it('has empty array representation by default', function () {
    expect($this->tooltip->toArray())->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->tooltip->textStyle)
        ->toBeInstanceOf(HigherOrderTextStyle::class);
});

it('serializes tooltip trigger position and chrome', function () {
    $this->tooltip
        ->show()
        ->triggerByItem()
        ->zlevel(2)
        ->z(20)
        ->left(120)
        ->top('10%')
        ->backgroundColor('#ffffff')
        ->borderColor('#ddd')
        ->borderWidth(1)
        ->padding([5, 10]);

    $this->tooltip->textStyle->color('#333');

    expect($this->tooltip->toArray())->toEqual([
        'show' => true,
        'trigger' => 'item',
        'zlevel' => 2,
        'z' => 20,
        'left' => 120,
        'top' => '10%',
        'backgroundColor' => '#ffffff',
        'borderColor' => '#ddd',
        'borderWidth' => 1,
        'padding' => [5, 10],
        'textStyle' => [
            'color' => '#333',
        ],
    ]);
});
