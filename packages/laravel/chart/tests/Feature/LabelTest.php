<?php

declare(strict_types=1);

use Honed\Chart\Label;

beforeEach(function () {
    $this->label = Label::make();
});

it('has empty array representation by default', function () {
    expect($this->label->toArray())->toEqual([]);
});

it('serializes label style options', function () {
    $this->label
        ->show()
        ->color('#f00')
        ->fontStyle('normal')
        ->fontWeight(600)
        ->fontFamily('monospace')
        ->fontSize(11)
        ->lineHeight(14)
        ->backgroundColor('#fafafa')
        ->borderColor('#999')
        ->borderWidth(1)
        ->borderType('solid')
        ->dashOffset(0)
        ->borderRadius([2, 4, 2, 4])
        ->padding(4)
        ->shadowBlur(1)
        ->shadowColor('rgba(0,0,0,0.2)')
        ->shadowOffsetX(0)
        ->shadowOffsetY(1)
        ->width(120)
        ->height(20)
        ->overflow('break');

    expect($this->label->toArray())->toEqual([
        'show' => true,
        'color' => '#f00',
        'fontStyle' => 'normal',
        'fontWeight' => 600,
        'fontFamily' => 'monospace',
        'fontSize' => 11,
        'lineHeight' => 14,
        'backgroundColor' => '#fafafa',
        'borderColor' => '#999',
        'borderWidth' => 1,
        'borderType' => 'solid',
        'borderDashOffset' => 0,
        'borderRadius' => [2, 4, 2, 4],
        'padding' => 4,
        'shadowBlur' => 1,
        'shadowColor' => 'rgba(0,0,0,0.2)',
        'shadowOffsetX' => 0,
        'shadowOffsetY' => 1,
        'width' => 120,
        'height' => 20,
        'overflow' => 'break',
    ]);
});
