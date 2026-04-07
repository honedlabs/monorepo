<?php

declare(strict_types=1);

use Honed\Chart\AxisPointer;
use Honed\Chart\Enums\AxisPointerType;
use Honed\Chart\Proxies\HigherOrderAxisPointerLabel;
use Honed\Chart\Proxies\HigherOrderLineStyle;
use Honed\Chart\Proxies\HigherOrderShadowStyle;

beforeEach(function () {
    $this->axisPointer = AxisPointer::make();
});

it('has empty array representation by default', function () {
    expect($this->axisPointer->toArray())->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->axisPointer->label)->toBeInstanceOf(HigherOrderAxisPointerLabel::class);

    expect($this->axisPointer->lineStyle)->toBeInstanceOf(HigherOrderLineStyle::class);

    expect($this->axisPointer->shadowStyle)->toBeInstanceOf(HigherOrderShadowStyle::class);

    expect($this->axisPointer->crossStyle)->toBeInstanceOf(HigherOrderLineStyle::class);
});

it('serializes axis pointer options', function () {
    $this->axisPointer
        ->type(AxisPointerType::Shadow)
        ->snap()
        ->triggerTooltip()
        ->pointerAnimation()
        ->animationDurationUpdate(200)
        ->label(fn ($label) => $label
            ->show()
            ->precision(2)
            ->formatter('{value}')
            ->textStyle(fn ($ts) => $ts->fontSize(10))
        )
        ->lineStyle(fn ($lineStyle) => $lineStyle->color('#0f0')->width(2))
        ->shadowStyle->color('rgba(0,0,0,0.2)')
        ->crossStyle->dashed();

    expect($this->axisPointer->toArray())->toEqual([
        'type' => AxisPointerType::Shadow->value,
        'snap' => true,
        'label' => [
            'show' => true,
            'precision' => 2,
            'formatter' => '{value}',
            'textStyle' => [
                'fontSize' => 10,
            ],
        ],
        'animation' => true,
        'animationDurationUpdate' => 200,
        'lineStyle' => [
            'color' => '#0f0',
            'width' => 2,
        ],
        'shadowStyle' => [
            'color' => 'rgba(0,0,0,0.2)',
        ],
        'crossStyle' => [
            'type' => 'dashed',
        ],
        'triggerTooltip' => true,
    ]);
});
