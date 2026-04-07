<?php

declare(strict_types=1);

use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\Tooltip;

beforeEach(function () {
    $this->tooltip = Tooltip::make();
});

it('has array representation', function () {
    expect($this->tooltip)
        ->toArray()->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->tooltip->textStyle)
        ->toBeInstanceOf(HigherOrderTextStyle::class);
});