<?php

declare(strict_types=1);

use Honed\Chart\Proxies\HigherOrderTextStyle;
use Honed\Chart\Title;

beforeEach(function () {
    $this->title = Title::make();
});

it('has array representation', function () {
    expect($this->title)
        ->toArray()->toEqual([]);
});

it('has higher order proxies', function () {
    expect($this->title->textStyle)
        ->toBeInstanceOf(HigherOrderTextStyle::class);
});
