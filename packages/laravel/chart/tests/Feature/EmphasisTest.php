<?php

declare(strict_types=1);

use Honed\Chart\Emphasis;
use Honed\Chart\Enums\BlurScope;
use Honed\Chart\Enums\Focus;
use Honed\Chart\Proxies\HigherOrderAreaStyle;
use Honed\Chart\Proxies\HigherOrderItemStyle;
use Honed\Chart\Proxies\HigherOrderLabel;
use Honed\Chart\Proxies\HigherOrderLabelLine;
use Honed\Chart\Proxies\HigherOrderLineStyle;

beforeEach(function () {
    $this->emphasis = Emphasis::make();
});

it('has empty array representation by default', function () {
    expect($this->emphasis->toArray())->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->emphasis->label)->toBeInstanceOf(HigherOrderLabel::class);

    expect($this->emphasis->labelLine)->toBeInstanceOf(HigherOrderLabelLine::class);

    expect($this->emphasis->itemStyle)->toBeInstanceOf(HigherOrderItemStyle::class);

    expect($this->emphasis->lineStyle)->toBeInstanceOf(HigherOrderLineStyle::class);

    expect($this->emphasis->areaStyle)->toBeInstanceOf(HigherOrderAreaStyle::class);
});

it('serializes emphasis options for echarts', function () {
    $this->emphasis
        ->disabled()
        ->scale()
        ->scaleSize(10)
        ->focus(Focus::Series)
        ->blurScope(BlurScope::Global)
        ->label(fn ($label) => $label->show()->color('#fff'))
        ->labelLine(fn ($ll) => $ll
            ->show()
            ->length(12)
            ->lineStyle(fn ($ls) => $ls->color('#888')->width(1))
        )
        ->itemStyle->color('#f00')
        ->lineStyle->width(3)
        ->areaStyle->opacity(50);

    expect($this->emphasis->toArray())->toEqual([
        'disabled' => true,
        'scale' => true,
        'scaleSize' => 10,
        'focus' => Focus::Series->value,
        'blurScope' => BlurScope::Global->value,
        'label' => [
            'show' => true,
            'color' => '#fff',
        ],
        'labelLine' => [
            'show' => true,
            'length' => 12,
            'lineStyle' => [
                'color' => '#888',
                'width' => 1,
            ],
        ],
        'itemStyle' => [
            'color' => '#f00',
        ],
        'lineStyle' => [
            'width' => 3,
        ],
        'areaStyle' => [
            'opacity' => 50,
        ],
    ]);
});
