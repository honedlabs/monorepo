<?php

declare(strict_types=1);

use Honed\Chart\LabelLine;
use Honed\Chart\LineStyle;
use Honed\Chart\Proxies\HigherOrderLineStyle;

beforeEach(function () {
    $this->labelLine = LabelLine::make();
});

it('has empty array representation by default', function () {
    expect($this->labelLine->toArray())->toEqual([]);
});

it('has higher order lineStyle proxy', function () {
    expect($this->labelLine->lineStyle)->toBeInstanceOf(HigherOrderLineStyle::class);
});

it('serializes label line options', function () {
    $this->labelLine
        ->show()
        ->length(8)
        ->length2(14)
        ->smooth()
        ->lineStyle(fn (LineStyle $ls) => $ls->color('#abc')->width(1));

    expect($this->labelLine->toArray())->toEqual([
        'show' => true,
        'length' => 8,
        'length2' => 14,
        'smooth' => true,
        'lineStyle' => [
            'color' => '#abc',
            'width' => 1,
        ],
    ]);
});
