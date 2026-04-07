<?php

declare(strict_types=1);

use Honed\Chart\TextStyle;

beforeEach(function () {
    $this->textStyle = TextStyle::make();
});

it('has empty array representation by default', function () {
    expect($this->textStyle->toArray())->toEqual([]);
});

it('serializes text and border fields to echarts textStyle keys', function () {
    $this->textStyle
        ->color('#abc')
        ->fontStyle('italic')
        ->fontWeight('bold')
        ->fontFamily('sans-serif')
        ->fontSize(13)
        ->lineHeight(18)
        ->width(100)
        ->height(24)
        ->overflow('truncate')
        ->borderColor('#112233')
        ->borderWidth(2)
        ->borderType('dashed')
        ->shadowBlur(3)
        ->shadowColor('rgba(0,0,0,0.4)')
        ->shadowOffsetX(1)
        ->shadowOffsetY(-1);

    expect($this->textStyle->toArray())->toEqual([
        'color' => '#abc',
        'fontStyle' => 'italic',
        'fontWeight' => 'bold',
        'fontFamily' => 'sans-serif',
        'fontSize' => 13,
        'lineHeight' => 18,
        'width' => 100,
        'height' => 24,
        'textBorderColor' => '#112233',
        'textBorderWidth' => 2,
        'textBorderType' => 'dashed',
        'textShadowBlur' => 3,
        'textShadowColor' => 'rgba(0,0,0,0.4)',
        'textShadowOffsetX' => 1,
        'textShadowOffsetY' => -1,
        'overflow' => 'truncate',
    ]);
});
