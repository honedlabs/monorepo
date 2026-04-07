<?php

declare(strict_types=1);

use Honed\Chart\LineStyle;

beforeEach(function () {
    $this->lineStyle = LineStyle::make();
});

it('has array representation', function () {
    expect($this->lineStyle)
        ->toArray()->toEqual([]);
});
