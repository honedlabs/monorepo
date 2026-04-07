<?php

declare(strict_types=1);

use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\TextStyle;
use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has empty array representation by default', function () {
    expect($this->title->toArray())->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->title->textStyle)
        ->toBeInstanceOf(HigherOrderTextStyle::class);
});

it('serializes title text position and nested textStyle', function () {
    $this->title
        ->id('title-1')
        ->show()
        ->text('Sales')
        ->zlevel(0)
        ->z(5)
        ->left('center')
        ->top(12)
        ->right(null)
        ->bottom('auto')
        ->textStyle(fn (TextStyle $textStyle) => $textStyle
            ->color('#111')
            ->fontSize(16)
        );

    expect($this->title->toArray())->toEqual([
        'id' => 'title-1',
        'show' => true,
        'text' => 'Sales',
        'textStyle' => [
            'color' => '#111',
            'fontSize' => 16,
        ],
        'zlevel' => 0,
        'z' => 5,
        'left' => 'center',
        'top' => 12,
        'bottom' => 'auto',
    ]);
});
