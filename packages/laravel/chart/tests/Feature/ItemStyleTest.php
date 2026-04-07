<?php

declare(strict_types=1);

use Honed\Chart\ItemStyle;

beforeEach(function () {
    $this->itemStyle = ItemStyle::make();
});

it('has array representation', function () {
    expect($this->itemStyle)
        ->toArray()->toEqual([]);
});
